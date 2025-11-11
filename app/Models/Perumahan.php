<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perumahan extends Model
{
    use HasFactory;
    protected $table = 'perumahan';
     protected $fillable = [
        'perumahan',
        'lokasi',
        'luas',
        'unit',
        'kota',
        'satuan',
        'harga',
        'harga_asli',
        'brosur',
        'pricelist',
        'img',
        'status',
        'keunggulan',
        'tipe',
        'fasilitas',
        'maps',
        'deskripsi',
        'video'
    ];

    // Model Perumahan.php
    public function images()
    {
        return $this->hasMany(PerumahanImage::class);
    }

    public function penawaran()
    {
        return $this->hasMany(Penawaran::class, 'perumahan_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

  public function affiliates()
{
    return $this->belongsToMany(
        Affiliate::class,
        'affiliate_perumahan',
        'perumahan_id',
        'affiliate_id'
    );
}


    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }


    public function survey()
    {
        return $this->hasMany(Survey::class, 'perumahan_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function commissions()
    {
        return $this->hasManyThrough(
            AffiliatesCommision::class,
            Affiliate::class,
            'perumahan_id',
            'affiliate_id',
            'id',
            'id'
        );
    }

}
