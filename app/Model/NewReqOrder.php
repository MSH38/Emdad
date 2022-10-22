<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NewReqOrder extends Model
{
    protected $casts = [
        'customer_id' => 'integer',
        'status' => 'string',

        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];
    public function conversations()
    {
        return $this->hasMany(NewReqOrderConv::class);
    }
}
