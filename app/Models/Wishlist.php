<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist';

    protected $fillable = [
        'nama',
        'no_hp',
        'domisili',
        'permintaan',
        'jenis',
        'lokasi',
        'spesifik_lokasi',
        'harga_budget',
        'keterangan',
        'approval',
        'status',
    ];
};
