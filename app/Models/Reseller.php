<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    use HasFactory;
    protected $table = 'reseller';

    protected $fillable = [
        'name',
        'no_hp',
        'pekerjaan',
        'kota',
        'alamat',
        'perumahan_id'
    ];

    public function konsumen()
    {
        return $this->hasMany(Konsumen::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class);
    }

}
