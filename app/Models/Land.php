<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    use HasFactory;

    protected $table = 'land';

    /**
     * Kolom yang dapat diisi secara massal (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'judul',        // Judul
        'lt',           // Luas Tanah
        'surat',        // Surat
        'lmb_pbg',      // LMB/PBG
        'harga',        // Harga
        'lokasi',       // Lokasi
        'kecamatan',    // Kecamatan
        'kota',         // Kota
        'deskripsi',    // Deskripsi
    ];

    /**
     * Kolom yang disembunyikan dari array/JSON output.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function imagesLand()
    {
        return $this->hasMany(LandImage::class, 'land_id'); // Pastikan foreign key benar
    }
}
