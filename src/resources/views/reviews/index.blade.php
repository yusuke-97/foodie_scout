@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 30px;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                @foreach ($reviews as $category_id => $reviews_category)
                    @foreach ($reviews_category as $review)
                        <div class="card mb-5">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <a href="{{ route('mypage.profile', $review->user->id) }}" id="small-profile-image-container" style="text-decoration: none;">
                                            @if($review->user->image)
                                                <img class="small-profile-image" src="{{ asset('/storage/profile_images/' . $review->user->image) }}" alt="プロフィール画像">
                                            @else
                                                <i class="fas fa-user small-profile-icon" style="color: #000000;"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-10">
                                        <a href="{{ route('mypage.profile', $review->user->id) }}" class="d-inline-block" style="text-decoration: none;">
                                            <span style="font-weight: bold; color: #000000;" class="me-3">{{ $review->user->name }}</span>
                                        </a>
                                        <medal-color :user-followed="{{ $review->user->followers->count() }}" class="d-inline-block"></medal-color>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div style="width: 100%; padding-top: 100%; position: relative;">
                                        <a href="{{ route('restaurants.show', $review->restaurant) }}" style="text-decoration: none;">
                                            <img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" src="{{ $review->restaurant->image }}" alt="{{ $review->restaurant->name }}">
                                        </a>
                                    </div>
                                    <a href="{{ route('restaurants.show', $review->restaurant) }}" style="text-decoration: none;">
                                        <p style="color: #1E90FF; font-weight: bold; font-size: 20px;" class="mb-0 mt-2">{{ $review->restaurant->name }}</p>
                                    </a>
                                    <p style="font-size: 12px;" class="mb-0">
                                        <span>{{ $review->restaurant->nearest_station }}駅</span>
                                        /
                                        <span style="font-weight: bold;">{{ $review->restaurant->category->name }}</span>
                                    </p>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <=round($review->restaurant->average_rating))
                                                    <span style="color: #FFA500; font-size: 16px;">★</span>
                                                @else
                                                    <span style="color: #DDDDDD; font-size: 16px;">★</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <h3 class="mb-0" style="color: red; font-weight: bold; vertical-align: middle; font-size: 16px;">{{number_format($review->restaurant->average_rating, 2) }}</h3>
                                    </div>
                                    @if($review->score === 5)
                                        <div>
                                            <strong>{{ $review->category->name }}ジャンル</strong>
                                            <span class="p-0 mb-2 first-ranked">1位</span>
                                            <strong>に評価しました</strong>
                                        </div>
                                    @elseif($review->score === 4)
                                        <div>
                                            <strong>{{ $review->category->name }}ジャンル</strong>
                                            <span class="p-0 mb-2 second-ranked">2位</span>
                                            <strong>に評価しました</strong>
                                        </div>
                                    @elseif($review->score === 3)
                                        <div>
                                            <strong>{{ $review->category->name }}ジャンル</strong>
                                            <span class="p-0 mb-2 third-ranked">3位</span>
                                            <strong>に評価しました</strong>
                                        </div>
                                    @endif
                                    <p style="font-size: 14px;" class="mb-0">{{ $review->content }}</p>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                {{ $review->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection