<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'follow_id', 'type'
    ];

    public function user()
    {
        return $this->belongsTo(Follow::class);
    }

    public function followers()
    {
        return $this->belongsTo(Follow::class, 'user_id')->orderBy('name');
    }

    public function followings()
    {
        return $this->belongsTo(User::class, 'follow_id')->orderBy('name');
    }

}
