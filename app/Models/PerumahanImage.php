<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerumahanImage extends Model
{
    use HasFactory;
    protected $table = 'perumahan_images';

    protected $fillable = [
        'perumahan_id',
        'image_path',
    ];

    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class);
    }

}
