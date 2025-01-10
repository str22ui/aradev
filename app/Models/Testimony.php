<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    protected $table = 'testimony'; // Nama tabel
    protected $fillable = ['name', 'image', 'testimony']; // Kolom yang dapat diisi
}
