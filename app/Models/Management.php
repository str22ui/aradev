<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Management extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $table = 'managements';

    public function getRouteKeyName(){
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }
}
