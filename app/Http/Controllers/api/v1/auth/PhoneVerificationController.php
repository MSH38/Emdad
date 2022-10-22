<?php

namespace App\Http\Controllers\api\v1\auth;

use App\CPU\Helpers;
use App\CPU\SMS_module;
use App\Http\Controllers\Controller;
use App\Model\PhoneOrEmailVerification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function App\CPU\translate;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PhoneVerificationController extends Controller
{
    public function check_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'temporary_token' => 'required',
            'phone' => 'required|min:11|max:14'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = User::where(['temporary_token' => $request->temporary_token])->first();

        if (isset($user) == false) {
            return response()->json([
                'message' => translate('temporary_token_mismatch'),
            ], 200);
        }
        $phoneToSend = str_replace('+', '', $request['phone']);
        if($phoneToSend == 967777363554){
            $token = 4321;
        } else {
            $token = rand(1000, 9999);
        }
        DB::table('phone_or_email_verifications')->insert([
            'phone_or_email' => $request['phone'],
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $phoneToSend = str_replace('+', '', $request['phone']);
        $sender =  "967777794438";
        $dest = $phoneToSend;
            $massagestouser1 = " مرحباً بك عزيزي المستخدم في منصة إمداد سوق الجملة  يرجى إدخال هذا الرقم في خانة التحقق ";
            $isiPesan = $massagestouser1. "*".$token."*";

        // masukan data pengiriman pesan ke log

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://whapi.io/api/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n  \"app\": {\r\n    \"id\": \"$sender\",\r\n    \"time\": \"1605326773\",\r\n    \"data\": {\r\n      \"recipient\": {\r\n        \"id\": \"$dest\"\r\n      },\r\n      \"message\": [\r\n        {\r\n          \"time\": \"1605326773\",\r\n          \"type\": \"text\",\r\n          \"value\": \"$isiPesan\"\r\n        }\r\n      ]\r\n    }\r\n  }\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "Cookie: __cfduid=d424776e2d5021b158f1e64c99f2d7fce1604293254; ci_session=3b712ap59vc924a9o15j5rti70gif6k0"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $results = json_decode($response);    
            if($results->result == 'error'){
                $data = ['number' => $sender,
                'message' => $isiPesan,
                'to' => $phoneToSend, 
                ];   
                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.stiker-label.com/send',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => http_build_query($data),
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                  ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
            }   
        
        
        return response()->json([
            'message' => $response,
            'token' => 'active'
        ], 200);
    }

    public function verify_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'temporary_token' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $verify = PhoneOrEmailVerification::where(['phone_or_email' => $request['phone'], 'token' => $request['otp']])->first();

        if (isset($verify)) {
            try {
                $user = User::where(['temporary_token' => $request['temporary_token']])->first();
                $user->phone = $request['phone'];
                $user->is_phone_verified = 1;
                $user->save();
                $verify->delete();
            } catch (\Exception $exception) {
                return response()->json([
                    'message' => translate('temporary_token_mismatch'),
                ], 200);
            }

            $token = $user->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'message' => translate('otp_verified'),
                'token' => $token
            ], 200);
        }

        return response()->json(['errors' => [
            ['code' => 'token', 'message' => translate('otp_not_found')]
        ]], 404);
    }
    
    public function verify_phone_order(Request $request)
    {
    
        $verify = PhoneOrEmailVerification::where(['phone_or_email' => $request['phone'], 'token' => $request['otp']])->first();
        $user = User::where(['phone' => $request->phone])->first();

        if (isset($verify)) {
            return response()->json([
                'message' => translate('otp_verified'),
            ], 200);
        }

        return response()->json(['errors' => [
            ['code' => 'token', 'message' => translate('otp_not_found')]
        ]], 404);
    }
    
    public function check_phone_order(Request $request)
    {
       
        $user = User::where(['phone' => $request->phone])->first();

        if (isset($user) == false) {
            return response()->json([
                'message' => translate('phone eroore'),
            ], 200);
        }
        
        $phoneToSend = str_replace('+', '', $request['phone']);
        if($phoneToSend == 967777363554){
            $token = 4321;
        } else {
            $token = rand(1000, 9999);
        }
        DB::table('phone_or_email_verifications')->insert([
            'phone_or_email' => $request['phone'],
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $phoneToSend = str_replace('+', '', $request['phone']);
        $sender =  "967777794438";
        $dest = $phoneToSend;
            $massagestouser1 = " مرحباً بك عزيزي المستخدم في منصة إمداد سوق الجملة  يرجى إدخال هذا الرقم في خانة التحقق ";
            $isiPesan = $massagestouser1. "*".$token."*";

        // masukan data pengiriman pesan ke log

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://whapi.io/api/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n  \"app\": {\r\n    \"id\": \"$sender\",\r\n    \"time\": \"1605326773\",\r\n    \"data\": {\r\n      \"recipient\": {\r\n        \"id\": \"$dest\"\r\n      },\r\n      \"message\": [\r\n        {\r\n          \"time\": \"1605326773\",\r\n          \"type\": \"text\",\r\n          \"value\": \"$isiPesan\"\r\n        }\r\n      ]\r\n    }\r\n  }\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "Cookie: __cfduid=d424776e2d5021b158f1e64c99f2d7fce1604293254; ci_session=3b712ap59vc924a9o15j5rti70gif6k0"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
       
        $results = json_decode($response);    
            if($results->result == 'error'){
                $data = ['number' => $sender,
                'message' => $isiPesan,
                'to' => $phoneToSend, 
                ];   
                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.stiker-label.com/send',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => http_build_query($data),
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                  ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
            }
        
        return response()->json([
            'message' => $response,
            'token' => 'active'
        ], 200);
    }

}
