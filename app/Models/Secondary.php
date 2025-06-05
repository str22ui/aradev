<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secondary extends Model
{
    use HasFactory;
    protected $table = 'secondary';
    protected $fillable = [
        'kode_listing',
        'status',        // Dijual/Disewakan
        'available',
        'kondisi',
        'judul',         // Judul
        'lt',            // Luas Tanah
        'lb',            // Luas Bangunan
        'kt',            // Kamar Tidur
        'ktp',           // Kamar Tidur Pembantu
        'km',            // Kamar Mandi
        'kmp',           // Kamar Mandi Pembantu
        'carport',       // Carport
        'garasi',        // Garasi
        'listrik',       // Listrik
        'air',           // Air
        'surat',         // Surat
        'imb',           // IMB
        'hadap',        // Hadap
        'posisi',        // Posisi (Hook/Badan)
        'furnish',       // Furnish (Semi furnished/Unfurnished)
        'lantai',
        'harga',         // Harga
        'lokasi',        // Lokasi
        'kecamatan',     // Kecamatan
        'kota',          // Kota
        'deskripsi',     // Deskripsi
        'video',         // video
        'user_id',         // video
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function imagesSecondary()
    {
        return $this->hasMany(SecondaryImage::class, 'secondary_id'); // Pastikan foreign key benar
    }

   public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
