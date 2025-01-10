<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secondary extends Model
{
    use HasFactory;
    protected $table = 'secondary';
    protected $fillable = [
        'status',        // Dijual/Disewakan
        'available',      
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
        'harga',         // Harga
        'lokasi',        // Lokasi
        'kecamatan',     // Kecamatan
        'kota',          // Kota
        'deskripsi',     // Deskripsi
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function imagesSecondary()
    {
        return $this->hasMany(SecondaryImage::class, 'secondary_id', 'id');
    }
}
