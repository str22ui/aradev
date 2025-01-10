<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;
    protected $table = 'info'; // Nama tabel
    protected $fillable = ['image', 'title', 'headline', 'description'];

    public function imagesInfo()
    {
        return $this->hasMany(InfoImage::class, 'info_id'); // Pastikan foreign key benar
    }
}
