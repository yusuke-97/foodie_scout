@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > 予約履歴
            </span>

            <div class="container mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">店舗名</th>
                            <th scope="col">来店日時</th>
                            <th scope="col">予約料金</th>
                            <th scope="col">詳細</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->restaurant->name }}</td>
                            <td>{{ $reservation->visit_datetime }}</td>
                            <td>{{ $reservation->reservation_fee }}</td>
                            <td>
                                <a href="{{ route('mypage.reservation_history_show', $reservation) }}">
                                    詳細を確認する
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection