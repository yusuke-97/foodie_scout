@extends('layouts.app')

@section('content')

<?php
$tomorrow = new DateTime('tomorrow');
$date = $tomorrow->format('Y-m-d');

$twoMonthsLater = (new DateTime())->modify('+2 months');
$lastDayOfTwoMonthsLater = $twoMonthsLater->format('Y-m-t');

$times = [];
$time = new DateTime('10:00');
$endTime = new DateTime('23:30');
$interval = new DateInterval('PT30M');

while ($time <= $endTime) {
    $times[] = $time->format('H:i');
    $time->add($interval);
}
$times[] = '24:00';
?>

<div class="row">
    <div class="col-12 position-relative">
        <form action="{{ route('search') }}" method="get" class="position-absolute search-container">
            <!-- エリア -->
            <input type="text" name="area" class="search-input" placeholder="エリア・駅 [例:渋谷]">

            <!-- ジャンル -->
            <input type="text" name="category" class="search-input" placeholder="ジャンル [例:寿司]">

            <!-- 日付 -->
            <input type="date" name="visit_date" class="search-input" value="{{ $date }}" min="{{ $date }}" max="{{ $lastDayOfTwoMonthsLater }}" style="width: 250px;">

            <!-- 時間 -->
            <select name="visit_time" class="search-input">
                @foreach($times as $t)
                <option value="{{ $t }}" @if($t=='17:00' ) selected @endif>{{ $t }}</option>
                @endforeach
            </select>

            <!-- 人数 -->
            <select name="number_of_guests" class="search-select">
                @for($i = 1; $i <= 50; $i++) <option value="{{ $i }}" @if($i==2) selected @endif>{{ $i }}名</option>
                    @endfor
            </select>

            <!-- 検索 -->
            <button type="submit" class="search-button">検索</button>
        </form>
    </div>
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
                <div class="mt-2">
                    <a href="{{ route('restaurants.show', $recommend_restaurant) }}" style="text-decoration: none;">
                        <span style="color: #1E90FF; font-weight: bold;">{{ $recommend_restaurant->name }}</span>
                    </a>
                    <p style="font-size: 12px; color: gray;" class="mb-0">
                        <span style="font-weight: bold;">{{ $recommend_restaurant->prefecture }}</span>
                        /
                        <span>{{ $recommend_restaurant->category->name }}</span>
                    </p>
                    <div class="d-flex mb-2 align-items-center">
                        <div class="me-3">
                            @for ($i = 1; $i <= 5; $i++) @if ($i <=round($recommend_restaurant->average_rating))
                                <span style="color: #FFA500; font-size: 14px;">★</span>
                                @else
                                <span style="color: #DDDDDD; font-size: 14px;">★</span>
                                @endif
                                @endfor
                        </div>
                        <h3 class="m-0" style="color: red; font-weight: bold; vertical-align: middle; font-size: 14px;">{{ number_format($recommend_restaurant->average_rating, 2) }}</h3>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <h2 style="font-weight: bold; margin-bottom: 20px;">注目の店舗</h2>
        <div class="row mb-5">
            @foreach ($recently_restaurants as $recently_restaurant)
            <div class="col-3">
                <a href="{{ route('restaurants.show', $recently_restaurant) }}" style="text-decoration: none;">
                    <img src=" {{ asset($recently_restaurant->image) }}" class="img-thumbnail">
                </a>
                <div class="mt-2">
                    <a href="{{ route('restaurants.show', $recently_restaurant) }}" style="text-decoration: none;">
                        <span style="color: #1E90FF; font-weight: bold;">{{ $recently_restaurant->name }}</span>
                    </a>
                    <p style="font-size: 12px; color: gray;" class="mb-0">
                        <span style="font-weight: bold;">{{ $recently_restaurant->prefecture }}</span>
                        /
                        <span>{{ $recently_restaurant->category->name }}</span>
                    </p>
                    <div class="d-flex mb-2 align-items-center">
                        <div class="me-3">
                            @for ($i = 1; $i <= 5; $i++) @if ($i <=round($recommend_restaurant->average_rating))
                                <span style="color: #FFA500; font-size: 14px;">★</span>
                                @else
                                <span style="color: #DDDDDD; font-size: 14px;">★</span>
                                @endif
                                @endfor
                        </div>
                        <h3 class="m-0" style="color: red; font-weight: bold; vertical-align: middle; font-size: 14px;">{{ number_format($recommend_restaurant->average_rating, 2) }}</h3>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <h2 style="font-weight: bold; margin-bottom: 20px;">人気ユーザー</h2>
        <div class="row mb-5">
            @foreach ($popular_users as $user)
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-3">
                                <div>
                                    <a href="{{ route('mypage.profile', $user->id) }}" id="small-profile-image-container" style="text-decoration: none;">
                                        @if($user->image)
                                        <img class="small-profile-image" src="{{ asset('/storage/profile_images/' . $user->image) }}" alt="プロフィール画像">
                                        @else
                                        <i class="fas fa-user small-profile-icon" style="color: #000000;"></i>
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="col-9 row">
                                <div class="col-10">
                                    <span style="font-weight: bold;">{{ $user->name }}</span>
                                    <p>{{ $user->followers_count }} フォロワー</p>
                                </div>
                                <div class="col-2">
                                    <medal-color :user-followed="{{ $user->followers->count() }}"></medal-color>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p style="font-weight: bold;" class="mb-0">
                            <i class="fa-solid fa-thumbs-up me-3"></i>
                            高評価を付けた店舗
                        </p>
                        @foreach ($user->reviews as $review)
                        <div class="row">
                            <hr class="mt-3">
                            <div class="col-4">
                                <a href="{{ route('restaurants.show', $review->restaurant) }}" style="text-decoration: none;">
                                    <img src="{{ $review->restaurant->image }}" style="width: 60px; height: 60px; object-fit: cover;">
                                </a>
                            </div>
                            <div class="col-8">
                                <a href="{{ route('restaurants.show', $review->restaurant) }}" style="text-decoration: none;">
                                    <p style="color: #1E90FF; font-weight: bold; font-size: 14px;" class="mb-0">{{ $review->restaurant->name }}</p>
                                </a>
                                <p style="font-size: 12px;" class="mb-0">
                                    <span>{{ $review->restaurant->namenearest_station }}駅</span>
                                    /
                                    <span style="font-weight: bold;">{{ $review->restaurant->category->name }}</span>
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @for ($i = 1; $i <= 5; $i++) @if ($i <=round($review->restaurant->average_rating))
                                            <span style="color: #FFA500; font-size: 14px;">★</span>
                                            @else
                                            <span style="color: #DDDDDD; font-size: 14px;">★</span>
                                            @endif
                                            @endfor
                                    </div>
                                    <h3 class="mb-0" style="color: red; font-weight: bold; vertical-align: middle; font-size: 14px;">{{number_format($review->restaurant->average_rating, 2) }}</h3>
                                </div>
                            </div>

                        </div>


                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection