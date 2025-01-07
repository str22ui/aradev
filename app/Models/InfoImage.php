<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoImage extends Model
{
    use HasFactory;
    protected $table = 'info_images';

    protected $fillable = [
        'info_id',
        'image_path',
    ];

    public function info()
    {
        return $this->belongsTo(Info::class);
    }
}
