<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'code',
        'email',
        'role',
        'password',
        'perumahan_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function perumahans()
    {
        return $this->belongsToMany(Perumahan::class);
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function reseller()
    {
        return $this->hasOne(Reseller::class);
    }

    public function affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    // Relasi polymorphic - User (Sales) bisa punya banyak Affiliate
    public function affiliatesReferred()
    {
        return $this->morphMany(Affiliate::class, 'referrer');
    }

    // Helper untuk cek apakah user adalah Sales
    public function isSales()
    {
        return in_array($this->role, ['sales', 'salesAdmin']);
    }

    // Helper untuk mendapatkan total affiliate yang direferensikan
    public function getTotalAffiliatesAttribute()
    {
        return $this->affiliatesReferred()->count();
    }
}
