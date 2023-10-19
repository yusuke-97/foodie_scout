<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Kyslik\ColumnSortable\Sortable;

class Restaurant extends Model
{
    use HasFactory, Favoriteable, Sortable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'seat',
        'postcode',
        'address',
        'prefecture',
        'city',
        'street_address',
        'nearest_station',
        'phone_number',
        'category_id',
        'image',
        'recommend_flag',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
}
