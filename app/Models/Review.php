<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable=['idUser',
                        'idFilm',
                        'reviewText',
                        'filmTitle'];

    public function like(){
        return $this->hasOne(Like::class);
    }

    public function watch(){
        return $this->hasOne(Watch::class);
    }

    public function rating(){
        return $this->hasOne(Rating::class);
    }
}
