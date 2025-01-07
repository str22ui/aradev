<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;

    protected $table = 'penawaran';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'domisili',
        'pekerjaan',
        'nama_kantor',
        'sumber_informasi',
        'perumahan_id',
        'agent_id',
        'payment',
        'income',
        'dp',
        'rumah_id',
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

    public function rumah()
    {
        return $this->belongsTo(Rumah::class);
    }

    // public function rumah()
    // {
    //     return $this->belongsTo(Rumah::class, 'rumah_id');
    // }

}
