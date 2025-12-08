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
        'joined_at',
        'perumahan_id',
        'referrer_type',  // Ditambahkan
        'referrer_id',    // Ditambahkan
    ];

    // Relasi polymorphic - referrer bisa Sales, Agent, atau User
    public function referrer()
    {
        return $this->morphTo();
    }

    // Helper untuk mendapatkan nama referrer
    public function getReferrerNameAttribute()
    {
        return $this->referrer ? $this->referrer->name : '-';
    }

    // Helper untuk mendapatkan kode referrer
    public function getReferrerCodeAttribute()
    {
        if (!$this->referrer) return '-';

        // Jika referrer adalah User
        if ($this->referrer_type === 'App\Models\User') {
            return $this->referrer->code ?? $this->referrer->email;
        }

        // Jika referrer adalah Agent atau model lain yang punya code
        return $this->referrer->code ?? '-';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perumahans()
    {
        return Perumahan::whereIn('id', json_decode($this->perumahan_id ?? '[]'))->get();
    }

    public function commissions()
    {
        return $this->hasMany(AffiliatesCommision::class, 'affiliate_id');
    }

    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class, 'perumahan_id');
    }
}
