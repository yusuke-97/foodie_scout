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
            <div class="d-flex mb-2">
                <h3 style="color: #FFA500;" class="me-3">★★★★★</h3>
                <h3 style="color: red; font-weight: bold;">5.00</h3>
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

            <div class="offset-1 col-11">
                <hr class="w-100">
                <h3 class="float-left">口コミ</h3>
            </div>

            <div class="offset-1 col-11">
                <!-- レビューを実装する箇所になります -->
            </div>
        </div>
        <div class="col-4" style="position: sticky; top: 0;">
            <reservation-display google-api-key="{{ ENV('GOOGLE_API_KEY') }}" :restaurant-id=" {{ $restaurant->id }}" :restaurant-name="'{{ $restaurant->name }}'" :restaurant-price="{{ $restaurant->price }}" :restaurant-seat="{{ $restaurant->seat }}" :restaurant-phone-number="'{{ $restaurant->phone_number }}'" :restaurant-start-time="'{{ $restaurant->start_time }}'" :restaurant-end-time="'{{ $restaurant->end_time }}'" :restaurant-closed-day="'{{ $restaurant->closed_day }}'" :user-point-balance="{{ Auth::user()->point }}">
            </reservation-display>
        </div>
    </div>
</div>
@endsection