<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'kantor',
        'tipe',
        'no_hp',
        'alamat',
        'perumahan_id'
    ];

    public function konsumen()
    {
       return $this->hasMany(Konsumen::class, 'agent_id');
    }

    public function penawaran()
    {
        return $this->hasMany(Penawaran::class, 'agent_id');
    }

    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class);
    }


}

