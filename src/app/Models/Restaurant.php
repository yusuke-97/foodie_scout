<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

class Restaurant extends Model
{
    use HasFactory, Favoriteable;

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
