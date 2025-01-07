<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    use HasFactory;

    protected $table = 'rumah';

    protected $fillable = [
        'no_kavling',
        'luas_tanah',
        'luas_bangunan',
        'posisi',
        'harga',
        'perumahan_id',
        'status',
    ];

    // Relasi ke tabel Perumahan
    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class);
    }

    // Relasi ke tabel Agent
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function penawaran()
    {
        return $this->hasMany(Penawaran::class, 'rumah_id');
    }

}
