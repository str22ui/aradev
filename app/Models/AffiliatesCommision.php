<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliatesCommision extends Model
{
  use HasFactory;

    protected $table = 'affiliates_commision';

    protected $fillable = [
        'affiliate_id',
        'perumahan_id',
        'bulan',
        'harga_pricelist',
        'biaya_legalitas',
        'net_price',
        'fee_2_5',
        'fee_affiliate_30',
        'sub_total_bulanan',
        'total',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

   public function perumahan()
{
    return $this->belongsTo(Perumahan::class, 'perumahan_id');
}
}
