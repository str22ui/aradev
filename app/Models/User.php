<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id']; // boleh diganti jadi $fillable juga

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



}

