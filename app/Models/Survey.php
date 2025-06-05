<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'survey';

    protected $fillable = [
        'nama_konsumen',
        'no_hp',
        'email',
        'domisili',
        'pekerjaan',
        'nama_kantor',
        'perumahan',
        'tanggal_janjian',
        'waktu_janjian',
        'sumber_informasi',
        'agent_id',
        'reseller_id',
        'user_id'
    ];

    /**
     * Relationship with Agent.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }
    public function rumah()
    {
        return $this->belongsTo(Rumah::class);
    }

    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class);
    }

      public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
