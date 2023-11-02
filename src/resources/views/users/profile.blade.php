@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 30px;">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="row">
                <!-- プロフィール画像とユーザー名表示エリア -->
                <div class="col-4">
                    <div id="profile-image-container">
                        @if($user->image)
                        <img class="profile-image" src="{{ asset('/storage/profile_images/' . $user->image) }}" alt="プロフィール画像">
                        @else
                        <i class="fas fa-user profile-icon"></i>
                        @endif
                    </div>
                    <p class="mt-2" style="font-weight: bold;">{{ "@" . $user->user_name }}</p>
                </div>

                <!-- ユーザーの詳細情報表示エリア -->
                <div class="col-8">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h4 class="mb-0 mr-2" style="font-weight: bold;">{{ $user->name }}</h4>
                        <medal-color :user-followed="{{ $user->followers->count() }}"></medal-color>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <!-- フォロワー数 -->
                        <div class="text-center">
                            <div>フォロワー</div>
                            <div><strong>{{ $user->followers->count() }}</strong></div>
                        </div>

                        <!-- 行ったお店 -->
                        <div class="text-center">
                            <div>行ったお店</div>
                            <div><strong>{{ $user->reservations->pluck('restaurant_id')->unique()->count() }}</strong></div>
                        </div>

                        <!-- 口コミ数 -->
                        <div class="text-center">
                            <div>口コミ</div>
                            <div><strong>{{ $user->reviews->count() }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->id === $user->id)
            <div class="justify-content-center mb-4">
                <a href="{{ route('reviews.ranking') }}" class="btn submit-button mb-2" style="font-size: 12px;">
                    <i class="fa-solid fa-ranking-star"></i> ランキング作成
                </a>
            </div>
            @endif

            <div class="row mb-2">
                <div class="col-1 text-center p-0"></div>
                <div class="col-11 row">
                    <div class="col-4 text-center p-0 first-ranked">1位</div>
                    <div class="col-4 text-center p-0 second-ranked">2位</div>
                    <div class="col-4 text-center p-0 third-ranked">3位</div>
                </div>
            </div>

            <div class="row">
                <hr class="mb-0">
            </div>

            @foreach ($reviews as $category_id => $review_group)
            <div class="row">
                <div class="col-1 p-0 vertical-container">
                    <div class="vertical-text">
                        <a href="{{ route('reviews.edit_ranking', $review_group->first()->category->id) }}" style="text-decoration: none; color: #000000;">
                            <span style="font-size: 14px; font-weight: bold;" class="mb-2">{{ $review_group->first()->category->name }}</span>
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                </div>

                <div class="col-11 row">
                    @foreach ($review_group as $review)
                    <div class="col-4" style="padding: 4px;">
                        <div class="ranking-image-container" style="position: relative;">
                            <img src="{{ asset($review->restaurant->image) }}">
                            <div style="position: absolute; top: 20%; left: 0; width: 100%; text-align: center; color: #ffffff; background-color: rgba(0, 0, 0, 0.5); font-size: 18px; font-weight: bold;">
                                {{ $review->restaurant->name }}
                            </div>
                            <div style="position: absolute; top: 70%; left: 0; width: 100%; text-align: center; color: #ffffff; font-size: 12px; font-weight: bold;">
                                {{ $review->restaurant->prefecture }} {{ $review->restaurant->city }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection