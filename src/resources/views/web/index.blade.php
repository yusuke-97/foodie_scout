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


    <div class="position-relative">
        <form action="{{ route('search') }}" method="get" class="position-absolute search-container">
            <!-- エリア -->
            <input type="text" name="area" class="search-input" placeholder="エリア・駅" autocomplete="off">

            <!-- ジャンル -->
            <input type=" text" name="category" class="search-input" placeholder="ジャンル" autocomplete="off">

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
                @for($i = 1; $i <= 50; $i++)
                    <option value="{{ $i }}" @if($i==2) selected @endif>{{ $i }}名</option>
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
                { id: 5, src: '{{ asset('img/korean_food1.jpg') }}', alt: 'Image 5' }]">
    </image-slider>

    <div class="d-flex justify-content-center mt-4 mb-4">
        @include('modals.search_modal')
        <a href="#searchModal" class="search-modal-link btn submit-button" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="fa-solid fa-magnifying-glass me-1"></i>
            条件で検索する
        </a>
    </div>

    <div class="mb-5">
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
                        <div>
                            <a href="{{ route('restaurants.show', $recommend_restaurant) }}" style="text-decoration: none;">
                                <span style="color: #1E90FF; font-weight: bold;" class="recommend-restaurant-name">{{ $recommend_restaurant->name }}</span>
                            </a>
                            <p class="recommend-restaurant-information">
                                <span style="font-weight: bold;">{{ $recommend_restaurant->prefecture }}</span>
                                /
                                <span>{{ $recommend_restaurant->category->name }}</span>
                            </p>
                            <div class="d-flex mb-2 align-items-center">
                                <div class="recommend-average-rating-star">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <=round($recommend_restaurant->average_rating))
                                            <span style="color: #FFA500">★</span>
                                        @else
                                            <span style="color: #DDDDDD">★</span>
                                        @endif
                                    @endfor
                                </div>
                                <h3 class="recommend-average-rating-number">{{number_format($recommend_restaurant->average_rating, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <h2 style="font-weight: bold; margin-bottom: 20px;">注目の店舗</h2>
            <div class="row mb-5">
                @foreach ($recently_restaurants as $recently_restaurant)
                    <div class="col-4">
                        <a href="{{ route('restaurants.show', $recently_restaurant) }}" style="text-decoration: none;">
                            <img src=" {{ asset($recently_restaurant->image) }}" class="img-thumbnail">
                        </a>
                        <div>
                            <a href="{{ route('restaurants.show', $recommend_restaurant) }}" style="text-decoration: none;">
                                <span style="color: #1E90FF; font-weight: bold;" class="recommend-restaurant-name">{{ $recommend_restaurant->name }}</span>
                            </a>
                            <p class="recommend-restaurant-information">
                                <span style="font-weight: bold;">{{ $recently_restaurant->prefecture }}</span>
                                /
                                <span>{{ $recently_restaurant->category->name }}</span>
                            </p>
                            <div class="d-flex mb-2 align-items-center">
                                <div class="d-flex mb-2 align-items-center">
                                    <div class="recommend-average-rating-star">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <=round($recently_restaurant->average_rating))
                                                <span style="color: #FFA500">★</span>
                                            @else
                                                <span style="color: #DDDDDD">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <h3 class="recommend-average-rating-number">{{number_format($recently_restaurant->average_rating, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <h2 style="font-weight: bold; margin-bottom: 20px;">人気ユーザー</h2>
            <div class="row mb-5">
                @foreach ($popular_users as $user)
                    <div class="col-6 col-lg-3">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-2 p-0">
                                        <div class="ratio ratio-1x1">
                                            <a href="{{ route('mypage.profile', $user->id) }}" class="small-profile-image-container" style="text-decoration: none;">
                                                @if($user->image)
                                                    <img class="small-profile-image" src="{{ asset('/storage/profile_images/' . $user->image) }}" alt="プロフィール画像">
                                                @else
                                                    <i class="fas fa-user small-profile-icon" style="color: #000000;"></i>
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-10 p-0">
                                        <div style="display: flex; align-items: center;">
                                            <a href="{{ route('mypage.profile', $user->id) }}" class="d-inline-flex align-items-center" style="text-decoration: none;">
                                                <span style="font-weight: bold; color: #000000;" class="popular-user-name">{{ $user->name }}</span>
                                            </a>
                                            <medal-color :user-followed="{{ $user->followers->count() }}" class="d-inline-flex align-items-center"></medal-color>
                                        </div>
                                        <p class="popular-user-information">
                                            <span>
                                                口コミ {{ $user->reviews->count() }}件
                                            </span>
                                            |
                                            <span>
                                                フォロワー {{ $user->followers->count() }}人
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p style="font-weight: bold;" class="mb-2 popular-user-ranking">
                                    <i class="fa-solid fa-thumbs-up me-3"></i>
                                    高評価を付けた店舗
                                </p>
                                @foreach ($user->reviews as $review)
                                    <div class="row">
                                        <hr class="mt-2 mb-2">
                                        <div class="col-4 p-0">
                                            <div class="ratio ratio-1x1">
                                                <a href="{{ route('restaurants.show', $review->restaurant) }}" id="restaurant-image-container" style="text-decoration: none;">
                                                    <img src="{{ $review->restaurant->image }}" class="popular-user-restaurant-image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-8 p-0">
                                            <a href="{{ route('restaurants.show', $review->restaurant) }}" style="text-decoration: none;">
                                                <p class="mb-0 popular-user-restaurant-name">{{ $review->restaurant->name }}</p>
                                            </a>
                                            <p class="mb-0 popular-user-restaurant-station">
                                                <span>{{ $review->restaurant->nearest_station }}駅</span>
                                                /
                                                <span style="font-weight: bold;">{{ $review->restaurant->category->name }}</span>
                                            </p>
                                            <div class="d-flex align-items-center">
                                                <div class="restaurant-average-rating-star">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <=round($review->restaurant->average_rating))
                                                            <span style="color: #FFA500">★</span>
                                                        @else
                                                            <span style="color: #DDDDDD">★</span>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <h3 class="restaurant-average-rating-number">{{number_format($review->restaurant->average_rating, 2) }}</h3>
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