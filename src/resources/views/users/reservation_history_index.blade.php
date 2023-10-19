@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <span>
            <a href="{{ route('mypage') }}">マイページ</a> > 予約履歴
        </span>

        <h4 class="mt-3" style="font-weight: bold;">予約一覧</h4>

        @foreach($reservations as $reservation)
        <div class="card mb-4">
            <div class="card-header">
                @if(strtotime($reservation->visit_date . ' ' . $reservation->visit_time) < strtotime(now()))
                    <span style="background-color: #0fbe9f; padding: 4px 24px; color: #ffffff; border-radius: 4px; font-size: 12px;" class="me-4">来店済み</span>
                    <span style="font-size: 12px;">ご来店ありがとうございました。</span>
                @else
                    <span style="background-color: #1E90FF; padding: 4px 24px; color: #ffffff; border-radius: 4px; font-size: 12px;" class="me-4">来店予定</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <img src="{{ asset($reservation->restaurant->image)}}" style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="flex-column">
                            <h5>
                                <a href="{{ route('restaurants.show', $reservation->restaurant) }}" style="color: #1E90FF; text-decoration: none; font-weight: bold;">{{ $reservation->restaurant->name }}</a>
                            </h5>
                            <div class="row">
                                <div class="col-4 mt-2">
                                    <span style="background-color: #ddd; padding: 0 8px;">来店日時</span>
                                </div>
                                <div class="col-8 mt-2">
                                    {{ date('Y年m月d日', strtotime($reservation->visit_date)) }}
                                    ({{ ['日', '月', '火', '水', '木', '金', '土'][date('w', strtotime($reservation->visit_date))] }})
                                    {{ date('H:i', strtotime($reservation->visit_time)) }}
                                </div>

                                <div class="col-4 mt-2">
                                    <span style="background-color: #ddd; padding: 0 8px;">来店人数</span>
                                </div>
                                <div class="col-8 mt-2">
                                    {{ $reservation->number_of_guests }}
                                </div>

                                <div class="col-4 mt-2">
                                    <span style="background-color: #ddd; padding: 0 8px;">予約料金</span>
                                </div>
                                <div class="col-8 mt-2">
                                    {{ number_format($reservation->reservation_fee) }} P
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <a>口コミを投稿</a>
                        <br>
                        <a href="{{ route('restaurants.show', $reservation->restaurant) }}">もう一度予約</a>
                        <br>
                        <a href="{{ route('mypage.reservation_history_show', $reservation) }}">予約詳細の確認</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection