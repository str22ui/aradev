<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['judul', 'short_desc', 'image','long_desc', 'no_hp'];
    public function imagesService()
    {
        return $this->hasMany(ServiceImage::class, 'service_id'); // Pastikan foreign key benar
    }
}

