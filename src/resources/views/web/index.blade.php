@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-5">
        <image-slider :images="[
            { id: 1, src: '{{ asset('img/japanese_food2.jpg') }}', alt: 'Image 1' },
            { id: 2, src: '{{ asset('img/japanese_food1.jpg') }}', alt: 'Image 2' },
            { id: 3, src: '{{ asset('img/western_food1.jpg') }}', alt: 'Image 3' },
            { id: 4, src: '{{ asset('img/chinese_food1.jpg') }}', alt: 'Image 4' },
            { id: 5, src: '{{ asset('img/korean_food1.jpg') }}', alt: 'Image 5' }
        ]"></image-slider>
    </div>
    <div class="col-12 mb-5">
        @component('components.sidebar', ['categories' => $categories, 'major_categories' => $major_categories])
        @endcomponent
    </div>
    <div class="col-12">
        <div class="container">
            <h2 style="font-weight: bold; margin-bottom: 20px;">おすすめ店舗</h2>
            <div class="row mb-5">
                @foreach ($recommend_restaurants as $recommend_restaurant)
                <div class="col-4">
                    <a href="{{ route('restaurants.show', $recommend_restaurant) }}">
                        <img src="{{ asset($recommend_restaurant->image) }}" class="img-thumbnail">
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="restaurant-label mt-2">
                                <span style="color: #1E90FF; font-weight: bold;">{{ $recommend_restaurant->name }}</span>
                                <br>
                                <label>￥{{ $recommend_restaurant->price }}</label>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <h2 style="font-weight: bold; margin-bottom: 20px;">注目の店舗</h2>
            <div class="row mb-5">
                @foreach ($recently_restaurants as $recently_restaurant)
                <div class="col-3">
                    <a href="{{ route('restaurants.show', $recently_restaurant) }}">
                        <img src="{{ asset($recently_restaurant->image) }}" class="img-thumbnail">
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="restaurant-label mt-2">
                                <span style="color: #1E90FF; font-weight: bold;">{{ $recently_restaurant->name }}</span>
                                <br>
                                <label>￥{{ $recently_restaurant->price }}</label>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <h2 style="font-weight: bold; margin-bottom: 20px;">人気ユーザー</h2>
            <div class="row mb-5">

            </div>
        </div>
    </div>
</div>
@endsection