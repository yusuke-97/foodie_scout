@extends('layouts.app')

@section('content')

<div class="row justify-content-center" style="margin-top: 30px;">
    <div class="col-12 col-md-8">
        <h3 style="font-weight: bold; font-size: 24px;">予約一覧</h3>

        @foreach($reservations as $reservation)
        <div class="card mb-4">
            <div class="card-header">
                @if(strtotime($reservation->visit_date . ' ' . $reservation->visit_time) < strtotime(now())) <span style="background-color: #0fbe9f;" class="reservation-status">来店済み</span>
                    <span style="font-size: 12px;">ご来店ありがとうございました。</span>
                    @else
                    <span style="background-color: #1E90FF;" class="reservation-status">来店予定</span>
                    @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4 mt-2">
                        <div class="ratio ratio-1x1 mb-3">
                            <a href="{{ route('restaurants.show', $reservation->restaurant) }}" class="restaurant-image-container" style="text-decoration: none;">
                                <img src="{{ asset($reservation->restaurant->image)}}" class="restaurant-image">
                            </a>
                        </div>
                        @if(strtotime($reservation->visit_date . ' ' . $reservation->visit_time) > strtotime(now()))
                        <a href=" {{ route('reservation.edit', $reservation) }}" class="btn submit-button mb-2" style="font-size: 12px;">
                            <i class="fa-solid fa-pen-to-square"></i>
                            予約変更
                        </a>
                        @else
                        <a href="{{ route('restaurants.show', $reservation->restaurant) }}" class="btn submit-button mb-2" style="font-size: 10px; background-color: #1E90FF;">もう一度予約</a>
                        @endif
                    </div>
                    <div class="col-8 mt-2">
                        <div class="flex-column">
                            <a href="{{ route('restaurants.show', $reservation->restaurant) }}" style="color: #1E90FF; text-decoration: none; font-weight: bold;">
                                <p class="restaurant-name">{{ $reservation->restaurant->name }}</p>
                            </a>
                            <div class="row restaurant-content">
                                <div class="col-4 mt-2 p-0">
                                    <span style="background-color: #ddd; padding: 0 8px;">来店日時</span>
                                </div>
                                <div class="col-8 mt-2 p-0">
                                    {{ date('Y年m月d日', strtotime($reservation->visit_date)) }}
                                    ({{ ['日', '月', '火', '水', '木', '金', '土'][date('w', strtotime($reservation->visit_date))] }})
                                    {{ date('H:i', strtotime($reservation->visit_time)) }}
                                </div>

                                <div class="col-4 mt-2 p-0">
                                    <span style="background-color: #ddd; padding: 0 8px;">来店人数</span>
                                </div>
                                <div class="col-8 mt-2 p-0">
                                    {{ $reservation->number_of_guests }}
                                </div>

                                <div class="col-4 mt-2 p-0">
                                    <span style="background-color: #ddd; padding: 0 8px;">予約料金</span>
                                </div>
                                <div class="col-8 mt-2 p-0">
                                    {{ number_format($reservation->reservation_fee) }} P
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $reservations->links() }}
        </div>
    </div>
</div>

@endsection