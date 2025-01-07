<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'report';
    protected $fillable = [
        'konsumen_id',
        'pic',
        'follow_up',
        'status',
        'koresponden',
        'alasan',
        'no_hp',
        'tanggal'
    ];

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class);
    }
}
