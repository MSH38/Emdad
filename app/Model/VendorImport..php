<?php

namespace App\Model;

use App\Model\User;
use App\Model\Seller;
use App\Model\Shop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Auth;
use Storage;


class VendorImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
  
		private $rows = 0;
    
    public function collection(Collection $rows) {
        $canImport = true;
        if($canImport) {
            foreach ($rows as $row) {
                $userId = User::create([
						   'name' 			=> $row['name'],
                           'user_type'     	=> $row['user_type'] == 'seller' ? 'seller' : 'admin',
						   'email'    		=> $row['email'],
						   'email_verified_at'    => date('Y-m-d H:i:s'),
						   'password'    	=> Hash::make($row['password']),
						   'address'    	=> $row['address'],
						   'country'    	=> $row['country'],
						   'city'    		=> $row['city'],
						   'postal_code'    => $row['postal_code'],
						   'parent_user_id'    		=> $row['parent_user_id'],                            
						   'referred_by'    		=> $row['referred_by'],                            
						   'avatar'    				=> $row['avatar'],                            
						   'country'    			=> $row['country'],                            
						   'state'    				=> $row['state'],                            
						   'city'    			=> $row['city'],                            
						   'phone'    			=> $row['phone'],                            
						   'city_id'    		=> $row['city_id'],                            
						   'balance'    		=> $row['balance'],                            
						   'banned'    			=> $row['banned'],                            
						   'referral_code'    	=> $row['referral_code'],                            
						   'customer_package_id'=> $row['customer_package_id'],                           
						   'job_tyb'    		=> $row['job_tyb'],                            
						   'info_req'    		=> $row['info_req'],                            
                ]);
				Seller::create([
                    'user_id' => $userId->id,
                    'seller_package_id' => $row['seller_package_id'],
                    'remaining_uploads' => $row['remaining_uploads'],
                    'remaining_digital_uploads' => $row['remaining_digital_uploads'],
                    'invalid_at' => $row['invalid_at'],
                    'remaining_auction_uploads' => $row['remaining_auction_uploads'],
                    'rating' => $row['rating'],
                    'num_of_reviews' => $row['num_of_reviews'],
                    'num_of_sale' => $row['num_of_sale'],
                    'verification_status' => $row['verification_status'],
                    'verification_info' => $row['verification_info'],
                    'cash_on_delivery_status' => $row['cash_on_delivery_status'],
                    'admin_to_pay' => $row['admin_to_pay'],
                    'bank_name' => $row['bank_name'],
                    'bank_acc_name' => $row['bank_acc_name'],
                    'bank_acc_no' => $row['bank_acc_no'],
                    'bank_routing_no' => $row['bank_routing_no'],
                    'bank_payment_status' => $row['bank_payment_status'],
                ]);
				Shop::create([
                    'user_id' => $userId->id,
                    'name' => $row['nameshop'],
                    'logo' => $row['logo'],
                    'sliders' => $row['sliders'],
                    'phone' => $row['phone'],
                    'address' => $row['address'],
                    'slug' => $row['slug'],
                    'meta_title' => $row['meta_title'],
                    'meta_description' => $row['meta_description'],
                ]);
            }           
            flash(translate('Products imported successfully'))->success();
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
             'unit_price' => function($attribute, $value, $onFailure) {
                  if (!is_numeric($value)) {
                       $onFailure('Unit price is not numeric');
                  }
              }
        ];
    }
}
