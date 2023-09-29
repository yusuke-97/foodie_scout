@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories, 'major_categories' => $major_categories])
        @endcomponent
    </div>
    <div class="col-9">
        <h1>おすすめ店舗</h1>
        <div class="row">
            @foreach ($recommend_restaurants as $recommend_restaurant)
            <div class="col-4">
                <a href="{{ route('restaurants.show', $recommend_restaurant) }}">
                    <img src="{{ asset($recommend_restaurant->image) }}" class="img-thumbnail">
                </a>
                <div class="row">
                    <div class="col-12">
                        <p class="restaurant-label mt-2">
                            {{ $recommend_restaurant->name }}<br>
                            <label>￥{{ $recommend_restaurant->price }}</label>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <h1>新店舗</h1>
        <div class="row">
            @foreach ($recently_restaurants as $recently_restaurant)
            <div class="col-3">
                <a href="{{ route('restaurants.show', $recently_restaurant) }}">
                    <img src="{{ asset($recently_restaurant->image) }}" class="img-thumbnail">
                </a>
                <div class="row">
                    <div class="col-12">
                        <p class="restaurant-label mt-2">
                            {{ $recently_restaurant->name }}<br>
                            <label>￥{{ $recently_restaurant->price }}</label>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <h1>人気ユーザー</h1>
        <div class="row">

        </div>
    </div>
</div>
@endsection