@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 30px;">
    <div class="row justify-content-center">
        <div class="col-9 col-lg-6">
            <div class="row">
                <!-- プロフィール画像とユーザー名表示エリア -->
                <div class="col-4">
                    <div class="ratio ratio-1x1">
                        <div id="profile-image-container">
                            @if($user->image)
                            <img class="profile-image" src="{{ asset('/storage/profile_images/' . $user->image) }}" alt="プロフィール画像">
                            @else
                            <i class="fas fa-user profile-icon"></i>
                            @endif
                        </div>
                    </div>
                    <p id="profile-user-nickname" class="text-center">{{ "@" . $user->user_name }}</p>
                </div>

                <!-- ユーザーの詳細情報表示エリア -->
                <div class="col-8">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h4 id="profile-user-name">{{ $user->name }}</h4>
                        <medal-color :user-followed="{{ $user->followers->count() }}"></medal-color>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        @include('modals.show_followers')
                        <!-- フォロワー数 -->
                        <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#showFollowersModal">
                            <div class="text-center profile-number-detail">
                                <div>フォロワー</div>
                                <div><strong>{{ $user->followers->count() }}</strong></div>
                            </div>
                        </a>

                        @include('modals.show_followings')
                        <!-- フォロー中 -->
                        <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#showFollowingsModal">
                            <div class="text-center profile-number-detail">
                                <div>フォロー中</div>
                                <div><strong>{{ $user->followings->count() }}</strong></div>
                            </div>
                        </a>

                        <!-- 口コミ数 -->
                        <div class="text-center profile-number-detail">
                            <div>口コミ</div>
                            <div><strong>{{ $user->reviews->count() }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->id === $user->id)
            <div class="justify-content-center mb-2">
                <a href="{{ route('reviews.ranking') }}" class="btn submit-button mb-2" id="create-ranking-button">
                    <i class="fa-solid fa-ranking-star"></i> ランキング作成
                </a>
            </div>
            @else
            <div class="justify-content-center mb-4">
                <follow-button :is-following="{{ Auth::user()->isFollowing($user) ? 'true' : 'false' }}" :following-id="{{ $user->id }}"></follow-button>
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
                        <a href="{{ route('reviews.edit_ranking', $review_group->first()->category->id) }}" id="category-title">
                            <span class="mb-2">{{ $review_group->first()->category->name }}</span>
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                </div>

                <div class="col-11 row">
                    @foreach ($review_group as $review)
                    @include('modals.show_review')
                    <div class="col-4" style="padding: 4px;">
                        <div class="ranking-image-container" style="position: relative;" data-bs-toggle="modal" data-bs-target="#showReviewModal{{ $review->id }}">
                            <img src="{{ asset($review->restaurant->image) }}">
                            <div id="review-restaurant-name">
                                {{ $review->restaurant->name }}
                            </div>
                            <div id="review-restaurant-place">
                                <span>{{ $review->restaurant->prefecture }} {{ $review->restaurant->city }}</span>
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