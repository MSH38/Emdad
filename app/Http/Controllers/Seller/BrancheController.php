<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Branche;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Model\DeliveryMan;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use function App\CPU\translate;
use App\Model\Day;
use App\Model\DayShop;
use Auth;
use App\Models\User;
use App\Model\Seller;
use App\Model\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SellerWithdrawRequest;

class BrancheController extends Controller
{
  public function index()
    {
        $days = Day::all();
        return view('seller-views.branche.index', compact('days'));
    }

    public function list(Request $request)
    {
        $query_param = [];
        //$sellerId = auth('seller')->id(); auth('seller')->id()
        $sellerId = auth('seller')->id();
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $branche = Branche::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('branche_name', 'like', "%{$value}%")
                        ->orWhere('branche_address', 'like', "%{$value}%")
                        ->orWhere('main_branche_id', '=', $sellerId)
                        ->orWhere('manager_phone', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $branche = Branche::where('main_branche_id', $sellerId);
             // $branche = new Branche();
       }

        $branche = $branche->latest()->paginate(25)->appends($query_param);
        return view('seller-views.branche.list', compact('branche', 'search'));
    }

    public function search(Request $request)
    {
        $key = explode(' ', $request['search']);
        $branche = Branche::where(['seller_id' => 0])->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('branche_name', 'like', "%{$value}%")
                    ->orWhere('branche_address', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('manager_phone', 'like', "%{$value}%")
                    ->orWhere('identity_number', 'like', "%{$value}%");
            }
        })->get();
        return response()->json([
            'view' => view('seller-views.branche.partials._table', compact('branche'))->render()
        ]);
    }

    public function preview($id)
    {
        $dm = Branche::with(['reviews'])->where(['id' => $id])->first();
        return view('seller-views.branche.view', compact('dm'));
    }

    public function store(Request $request)
    {
        $seller_parent_id = auth('seller')->id();
        $seller_data = Seller::where('id', auth('seller')->id())->first();
        $shop_data = Shop::where('seller_id', auth('seller')->id())->first();
        $sellerId = auth('seller')->id();

        $request->validate([
            'branche_name' => 'required',
            'manager_phone' => 'required',
            'manager_phone' => 'required|unique:branche',
        ], [
            'branche_name.required' => 'First name is required!'
        ]);

        // $branche = Branche::where(['email' => $request['email'], 'seller_id' => 0])->first();
        // $branche_phone = Branche::where(['phone' => $request['phone'], 'seller_id' => 0])->first();

        // if (isset($branche)) {
        //     $request->validate([
        //         'email' => 'required|unique:branche',
        //     ]);
        // }

        // if (isset($branche_phone)) {
        //     $request->validate([
        //         'phone' => 'required|unique:branche',
        //     ]);
        // }

        if (!empty($request->file('branch_photo'))) {
            $identity_image = ImageManager::upload('branche/', 'png', $request->file('branch_photo'));
        } else {
            $identity_image = json_encode([]);
        }
        $branch_email = str_replace('+', '', $request->manager_phone);

       
        //انشاء مستخدم الفرع
       
        DB::transaction(function ($r) use ($request) {
        $seller_parent_id = auth('seller')->id();
        $seller_data = Seller::where('id', auth('seller')->id())->first();
        $shop_data = Shop::where('seller_id', auth('seller')->id())->first();
        $branch_email = str_replace('+', '', $request->manager_phone);
        $sellerId = auth('seller')->id();
        
        if (!empty($request->file('branch_photo'))) {
            $identity_image = ImageManager::upload('branche/', 'png', $request->file('branch_photo'));
        } else {
            $identity_image = json_encode([]);
        }
        $branch_email = str_replace('+', '', $request->manager_phone);
        
        $dm = new Branche();
        $dm->seller_parent = $sellerId;
        $dm->user_id = $sellerId;
        $dm->main_branche_id = $sellerId;
        $dm->branche_name = $request->branche_name;
        $dm->head_name = $shop_data->name;
        $dm->shop_name = $shop_data->name;
        $dm->branche_address = $request->address;
        $dm->address = $request->address;
        $dm->address_latitude = $request->latitude;
        $dm->address_longitude = $request->longitude;
        $dm->email = $request->email;
        $dm->manager_phone = '+967'.$request->manager_phone;
        $dm->manager_name = $request->manager_name;
        $dm->phone_mobile = '+967'.$request->manager_name;
        $dm->identity_number = $request->manager_phone;
        $dm->identity_type = 'passport';
        $dm->identity_image = $identity_image;
        $dm->branch_photo = $identity_image;
        $dm->menager_password = bcrypt($request->menager_password);


            $seller = new Seller();
            $seller->seller_parent = $seller_parent_id;
            $seller->f_name = $shop_data->name;
            $seller->l_name = $request->branche_name;
            $seller->phone = $request->manager_phone;
            $seller->email = $request->email;
            $seller->image = ImageManager::upload('seller/', 'png', $request->file('branch_photo'));
            $seller->password = bcrypt($request->menager_password);
            $seller->status =  'approved';
            $seller->save();

            $shop = new Shop();
            $shop->seller_id = $seller->id;
            $shop->seller_parent = $seller_parent_id;
            $shop->name = $shop_data->name . '-' . $request->branche_name;
            $shop->address = $request->address;
            $shop->contact = $request->manager_phone;
            $shop->image = ImageManager::upload('shop/', 'png', $request->file('branch_photo'));
            $shop->banner = ImageManager::upload('shop/banner/', 'png', $request->file('branch_photo'));
            $shop->save();

        $dm->seller_id = $seller['id'];
        $dm->user_id = $seller['id'];
        $dm->store_id = $shop['id'];
        $dm->shop_id = $shop['id'];
        $dm->save();
            
        DB::table('seller_wallets')->insert([
                'seller_id' => $seller['id'],
                'withdrawn' => 0,
                'commission_given' => 0,
                'total_earning' => 0,
                'pending_withdraw' => 0,
                'delivery_charge_earned' => 0,
                'collected_cash' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
        for($j=1; $j<8 ;$j++)
        {
            $shop_day = new DayShop();
            $shop_day->day_id = $j;
            $shop_day->shop_id = $shop->id;
            $shop_day->from_hours = '8';
            $shop_day->am_pm = "صباحاً";
            $shop_day->from_minutes = '00';
            $shop_day->to_hours = '08';
            $shop_day->to_minutes = '00';
            $shop_day->pm_am = "مساءً";
            $shop_day->save();
        }
        });
       

        if($request->status == 'approved'){
        Toastr::success('تم اضافة الفرع بنجاح');
            return back();
        }
        
        Toastr::success('تم اضافة الفرع بنجاح');
        return redirect('seller/branches/list');
    }

    public function edit($id)
    {
      $days = Day::all();
      $branche = Branche::find($id);
        return view('seller-views.branche.edit', compact('branche', 'days'));
    }

    public function status(Request $request)
    {
        $branche = Branche::find($request->id);
        $branche->is_active = $request->status;
        $branche->save();
        return response()->json([], 200);
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'branche_name' => 'required',
        ], [
            'branche_name.required' => 'First name is required!'
        ]);

        $branche = Branche::findOrFail($id);
        
        $branch_email = str_replace('+', '', $request->manager_phone);
        //$branche->seller_id = $seller->id;
        //$branche->user_id = $seller->id;
        $branche->branche_name = $request->branche_name;
        $branche->branche_address = $request->address;
        $branche->email = $request->email;
        $branche->address = $request->address;
        $branche->address_latitude = $request->latitude;
        $branche->address_longitude = $request->longitude;
        $branche->manager_phone = $request->manager_phone;
        $branche->manager_name = $request->manager_name;
        $branche->phone_mobile =  $request->phone_mobile;
        $branche->identity_number = $request->manager_phone;
        $branche->identity_type = 'passport';
        $branche->identity_image = $request->has('branch_photo') ? ImageManager::update('branche/', $branche->branch_photo, 'png', $request->file('branch_photo')) : $branche->branch_photo;
        $branche->branch_photo = $request->has('branch_photo') ? ImageManager::update('branche/', $branche->branch_photo, 'png', $request->file('branch_photo')) : $branche->branch_photo;
        $branche->menager_password = strlen($request->menager_password) > 1 ? bcrypt($request->menager_password) : $branche['menager_password'];
        $branche->save();
        
        if(strlen($request->menager_password) > 1) {
            $seller_branch_data = Seller::where('id', $branche->user_id)->first();
            $seller_branch_data->password = $request->menager_password;
            $seller_branch_data->save();
        }


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($branche->address).'&key=AIzaSyDuL9weltDy_kOcISLRucx5-JSFsezZpVE',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
 Log::info($branche->address);
 Log::info($response);
 $rs = json_decode($response, true);

    $state_name = $branche->state_name;
    $state_names = $branche->state_name;
    $city_names = $branche->city_name;


if (isset($rs['results'][0]['geometry']['location']['lat']) and trim($rs['results'][0]['geometry']['location']['lat']) != "") {
    $address_latitudes = $rs['results'][0]['geometry']['location']['lat'];
} else {
    $address_latitudes = $branche->address_latitude;
}

if (isset($rs['results'][0]['geometry']['location']['lng']) and trim($rs['results'][0]['geometry']['location']['lng']) != "") {
    $address_longitudes = $rs['results'][0]['geometry']['location']['lng'];
} else {
    $address_longitudes = $branche->address_longitude;
}

    if(isset($rs['results']))
        {
            foreach($rs['results'] as $result_map)
            {
              foreach($rs['results'][0]['address_components'] as $addressPart)
                {
                    if((in_array('sublocality_level_1', $addressPart['types'])) && (in_array('political', $addressPart['types'])))
                    {
                        $city1 = $addressPart['long_name'];
                        $city_names = $city1;
                    } 
                    if((in_array('locality', $addressPart['types'])) && (in_array('political', $addressPart['types'])))
                    {
                        $state = $addressPart['long_name'];
                        $state_names = $state;
                    }
                    if((in_array('country', $addressPart['types'])) && (in_array('political', $addressPart['types'])))
                    {
                        $country = $addressPart['long_name'];
                        $country_names = $country;
                    }
                }
            }
        }

        $branche->state_name = $state_names;
        $branche->city_name = $city_names;
        $branche->save();

        Toastr::success('Delivery-man updated successfully!');
        return redirect('seller/branches/list');
    }

    public function delete(Request $request)
    {
        $branche = Branche::find($request->id);
        if (Storage::disk('public')->exists('branche/' . $branche['branch_photo'])) {
            Storage::disk('public')->delete('branche/' . $branche['branch_photo']);
        }

        if (Storage::disk('public')->exists('branche/' . $branche['identity_image'])) {
            Storage::disk('public')->delete('branche/' . $branche['identity_image']);
        }
        
        $branche->delete();
        Toastr::success(translate('Delivery-man removed!'));
        return back();
    }
}
