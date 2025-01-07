<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    use HasFactory;
    protected $table = 'konsumen';
    protected $fillable = [
        'nama_konsumen',
        'no_hp',
        'email',
        'domisili',
        'pekerjaan',
        'nama_kantor',
        'perumahan',
        'sumber_informasi',
        'agent_id'
    ];

    public function report(){
        return $this->hasMany(Report::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
