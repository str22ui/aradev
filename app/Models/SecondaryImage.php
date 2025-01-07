<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryImage extends Model
{
    use HasFactory;

    protected $table = 'secondary_images';

    protected $fillable = [
        'secondary_id',
        'image_path',
    ];

    public function secondary()
    {
        return $this->belongsTo(Secondary::class);
    }

}


