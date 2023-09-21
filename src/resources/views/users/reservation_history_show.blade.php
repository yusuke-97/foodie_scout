@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > <a href="{{ route('mypage.reservation_history') }}">注文履歴</a> > 注文履歴詳細
            </span>

            <h1 class="mt-3">予約履歴詳細</h1>

            <h4 class="mt-3">ご予約情報</h4>

            <hr>

            <div class="row">
                <div class="col-md-5 mt-2">
                    <a href="{{route('restaurants.show', $reservation->restaurant->id)}}" class="ml-4">
                        <img src="{{ asset('img/foodie3.jpg')}}" class="img-fluid w-75">
                    </a>
                </div>
                <div class="col-md-7 mt-2">
                    <div class="flex-column">
                        <p class="mt-4">{{ $reservation->restaurant->name }}</p>
                        <div class="row">
                            <div class="col-6 mt-2">
                                予約日時
                            </div>
                            <div class="col-6 mt-2">
                                {{ $reservation->created_at }}
                            </div>

                            <div class="col-6 mt-2">
                                来店日時
                            </div>
                            <div class="col-6 mt-2">
                                {{ $reservation->visit_datetime }}
                            </div>

                            <div class="col-6 mt-2">
                                来店人数
                            </div>
                            <div class="col-6 mt-2">
                                {{ $reservation->number_of_guests }}
                            </div>

                            <div class="col-6 mt-2">
                                予約料金
                            </div>
                            <div class="col-6 mt-2">
                                {{ $reservation->reservation_fee }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection