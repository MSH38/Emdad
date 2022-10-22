<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DayShop extends Model
{
    protected $table = 'day_shop';

    protected $fillable = [
        'name', 'day_id', 'shop_id', 'from_hours', 'am_pm', 'from_minutes', 'to_hours', 'to_minutes', 'pm_am'
    ];
}
