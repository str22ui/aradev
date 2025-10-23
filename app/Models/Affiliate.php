<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'code',
    'name',
    'phone',
    'address',
    'referred_by_name',
    'referred_by_user_id',
    'referred_by_code',
    'commission_rate',
    'total_sales',
    'total_commission',
    'joined_at',
    'perumahan_id',
];

public function referrer()
{
    return $this->morphTo();
}

public function getReferrerNameAttribute()
{
    return $this->referrer ? $this->referrer->name : '-';
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function perumahans()
{
    return Perumahan::whereIn('id', json_decode($this->perumahan_id ?? '[]'))->get();
}



}




