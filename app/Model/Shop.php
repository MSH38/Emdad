<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $casts = [
        'seller_id ' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function scopeActive($query){
        return $query->whereHas('seller', function ($query) {
            $query->where(['status' => 'approved']);
        });
    }
    
    public function days()
    {
        return $this->belongsToMany(Day::class)->withPivot('from_hours', 'from_minutes', 'to_hours', 'to_minutes', 'am_pm', 'pm_am');
    }

}
