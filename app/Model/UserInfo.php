<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Model\Cart;
use App\Notifications\EmailVerificationNotification;

class UserInfo extends Model
{
   
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id', 'market_type', 'head_office', 'trade_name', 'trade_name_en', 'sale_type', 'sale_phone', 'market_department', 'sale_phone_home', 'moderia_name', 'avatar_sijel', 'avatar_shop', 'avatar_shop_logo', 'shop_about', 'shop_vision', 'shop_note', 'owner_name', 'owner_email', 'owner_phone', 'user_job', 'user_is_work', 'have_market', 'user_experience', 'user_one_work', 'user_tow_work', 'user_three_work', 'job_tyb'
    ];

}
