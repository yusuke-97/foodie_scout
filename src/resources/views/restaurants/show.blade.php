@extends('layouts.app')

@section('content')

<div class="mt-5" style="width: 961px; margin: 0 auto;">
    <div class="row">
        <div class="col-9">
            <div class="mb-3">
                <span style="background-color: #0fbe9f; color: #ffffff; padding: 4px 8px; border-radius: 4px;">公式</span>
            </div>
            <h2 style="font-weight: bold; margin-bottom: 8px;">
                {{$restaurant->name}}
            </h2>
            <div class="d-flex mb-2 align-items-center">
                <div class="me-3">
                    @for ($i = 1; $i <= 5; $i++) @if ($i <=round($restaurant->average_rating))
                        <span style="color: #FFA500; font-size: 24px;">★</span>
                        @else
                        <span style="color: #DDDDDD; font-size: 24px;">★</span>
                        @endif
                        @endfor
                </div>
                <h3 class="m-0" style="color: red; font-weight: bold; vertical-align: middle;">{{ number_format($restaurant->average_rating, 2) }}</h3>
            </div>

            <div class="d-flex mb-2">
                <p class="me-3">
                    <strong>最寄駅：</strong>{{$restaurant->nearest_station}}駅
                </p>
                <p class="me-3">
                    <strong>ジャンル：</strong>
                    {{$restaurant->category->name}}、
                    {{$restaurant->category->major_category->name}}
                </p>
                <p class="me-3">
                    <strong>予算：</strong>￥{{ number_format($restaurant->price) }}
                </p>
                <p>
                    <strong>営業時間：</strong>
                    {{ \Carbon\Carbon::parse($restaurant->start_time)->format('H:i') }} 〜
                    {{ \Carbon\Carbon::parse($restaurant->end_time)->format('H:i') }}
                </p>
            </div>
        </div>
        <div class="col-3">
            <favorite-button :is-favorited="{{ $restaurant->isFavoritedBy(Auth::user()) ? 'true' : 'false' }}" :restaurant-id="{{ $restaurant->id }}"></favorite-button>
        </div>
    </div>
</div>




<div class="mt-3" style="width: 961px; margin: 0 auto;">
    <div class="row">
        <div class="col-8">
            <img src="{{ asset($restaurant->image) }}" style="width: 100%; height: auto;">
            <h4 class="mt-4 mb-4 sub-title" style="font-weight: bold;">
                {{$restaurant->catchphrase}}
            </h4>
            <p>
                {{$restaurant->description}}
            </p>

            <hr>

            <h4 class="mt-5 mb-4 sub-title" style="font-weight: bold;">店舗基本情報</h4>
            <table id="restaurant-table">
                <tr>
                    <th class="tableheader-first col-4">店舗名</th>
                    <td class="cell-first col-8">{{$restaurant->name}}</td>
                </tr>
                <tr>
                    <th class="tableheader col-4">ジャンル</th>
                    <td class="cell col-8">
                        {{$restaurant->category->name}}、
                        {{$restaurant->category->major_category->name}}
                    </td>
                </tr>
                <tr>
                    <th class="tableheader col-4">予約・お問い合わせ</th>
                    <td class="cell col-8">{{$restaurant->phone_number}}</td>
                </tr>
                <tr>
                    <th class="tableheader col-4">住所</th>
                    <td class="cell col-8">{{$restaurant->address}}</td>
                </tr>
                <tr>
                    <th class="tableheader col-4">最寄駅</th>
                    <td class="cell col-8">{{$restaurant->nearest_station}}駅</td>
                </tr>
                <tr>
                    <th class="tableheader col-4">営業時間</th>
                    <td class="cell col-8">
                        {{ \Carbon\Carbon::parse($restaurant->start_time)->format('H:i') }} 〜
                        {{ \Carbon\Carbon::parse($restaurant->end_time)->format('H:i') }}
                        （料理L.O.{{ \Carbon\Carbon::parse($restaurant->end_time)->subHour(1)->format('H:i') }}、ドリンクL.O.{{ \Carbon\Carbon::parse($restaurant->end_time)->subMinutes(30)->format('H:i') }}）
                    </td>
                </tr>
                <tr>
                    <th class="tableheader col-4">休業日</th>
                    <td class="cell col-8">
                        @php
                        $weekdays = ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"];
                        @endphp

                        @if(is_null($restaurant->closed_day))
                        なし
                        @else
                        毎週{{ $weekdays[$restaurant->closed_day] }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="tableheader col-4">予算</th>
                    <td class="cell col-8">￥{{ number_format($restaurant->price) }}</td>
                </tr>
                <tr>
                    <th class="tableheader col-4">席数</th>
                    <td class="cell col-8">{{$restaurant->seat}}席</td>
                </tr>
            </table>

            <hr class="mt-5 mb-0">

            <h4 class="mt-4 mb-4 sub-title" style="font-weight: bold;">口コミ</h4>
            @foreach($reviews as $review)
            <div class="card mb-3">
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
                        <div class="col-6">
                            <a href="{{ route('mypage.profile', $review->user->id) }}" class="d-inline-block " style="text-decoration: none;">
                                <span style="font-weight: bold; color: #000000;" class="me-3">{{ $review->user->name }}</span>
                            </a>
                            <medal-color :user-followed="{{ $review->user->followers->count() }}" class="d-inline-block"></medal-color>
                            <p class="mb-0" style="color: gray;">
                                <span>
                                    口コミ {{ $review->user->reviews->count() }}件
                                </span>
                                |
                                <span>
                                    フォロワー {{ $review->user->followers->count() }}人
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($review->score === 5)
                    <div class="mb-3">
                        <strong>{{ $review->category->name }}ジャンル</strong>
                        <span class="p-0 mb-2 first-ranked">1位</span>
                        <strong>に評価しました</strong>
                    </div>
                    @elseif($review->score === 4)
                    <div class="mb-3">
                        <strong>{{ $review->category->name }}ジャンル</strong>
                        <span class="p-0 mb-2 second-ranked">2位</span>
                        <strong>に評価しました</strong>
                    </div>
                    @elseif($review->score === 3)
                    <div class="mb-3">
                        <strong>{{ $review->category->name }}ジャンル</strong>
                        <span class="p-0 mb-2 third-ranked">3位</span>
                        <strong>に評価しました</strong>
                    </div>
                    @endif
                    <p class="card-text">{{ $review->content }}</p>
                </div>
                <div class="card-footer text-muted">
                    {{ $review->created_at->diffForHumans() }}
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-4" style="position: sticky; top: 0;">
            <reservation-display google-api-key="{{ ENV('GOOGLE_API_KEY') }}" :restaurant-id=" {{ $restaurant->id }}" :restaurant-name="'{{ $restaurant->name }}'" :restaurant-price="{{ $restaurant->price }}" :restaurant-seat="{{ $restaurant->seat }}" :restaurant-phone-number="'{{ $restaurant->phone_number }}'" :restaurant-start-time="'{{ $restaurant->start_time }}'" :restaurant-end-time="'{{ $restaurant->end_time }}'" :restaurant-closed-day="'{{ $restaurant->closed_day }}'" :user-point-balance="{{ Auth::user()->point }}">
            </reservation-display>
        </div>
    </div>
</div>
@endsection