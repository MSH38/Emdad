<?php

namespace App\Model;

use App\Model\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Auth;
use Storage;


class UsersImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
		private $rows = 0;
    
    public function collection(Collection $rows) {
        $canImport = true;
        if($canImport) {
            foreach ($rows as $row) {
                $userId = User::create([
						   'name' 			        => $row['name'],
                           'user_type'     	        => $row['user_type'] == 'seller' ? 'seller' : 'customer',
						   'email'    		        => $row['email'],
						   'email_verified_at'      => date('Y-m-d H:i:s'),
						   'password'    	        => Hash::make($row['password']),
						   'address'    	        => $row['address'],
						   'country'    	        => $row['country'],
						   'city'    		        => $row['city'],
						   'parent_user_id'    		=> $row['parent_user_id'],                            
						   'referred_by'    		=> $row['referred_by'],                            
						   'avatar'    				=> $row['avatar'],                            
						   'country'    			=> $row['country'],                            
						   'state'    				=> $row['state'],                            
						   'city'    			    => $row['city'],                            
						   'city_id'    		    => $row['city_id'],                            
						   'phone'    		        => $row['phone'],                            
						   'balance'    		    => $row['balance'],                            
						   'banned'    			    => $row['banned'],                            
						   'referral_code'    	    => $row['referral_code'],                            
						   'customer_package_id'    => $row['customer_package_id'],                         
						   'job_tyb'    		    => $row['job_tyb'],                            
						   'info_req'    		    => $row['info_req'],                            
                ]);
            }           
            flash(translate('تم رفع المستخدمين للسيرفر بنجاح'))->success();
        } 
    }
	
	public function model(array $row)
    {
        ++$this->rows;
    }
    
    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
            
        ];
    }
}
