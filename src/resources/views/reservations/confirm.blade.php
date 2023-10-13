@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-9">

        <div class="main-header">
            {{ $reservation_data['restaurant_name'] }}
        </div>

        <!-- 予約者情報 -->
        <div class="reservation-card">
            <div class="reservation-header">予約者情報</div>
            <table class="reservation-table">
                <tbody>
                    <tr>
                        <td class="reservation-label">お名前</td>
                        <td class="reservation-value">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td class="reservation-label">電話番号</td>
                        <td class="reservation-value">{{ Auth::user()->phone_number }}</td>
                    </tr>
                    <tr>
                        <td class="reservation-label">メールアドレス</td>
                        <td class="reservation-value">{{ Auth::user()->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 予約内容確認 -->
        <div class="reservation-card">
            <div class="reservation-header">予約内容確認</div>
            <table class="reservation-table">
                <tbody>
                    <tr>
                        <td class="reservation-label">来店日時</td>
                        <td class="reservation-value">
                            {{ \Carbon\Carbon::parse($reservation_data['visit_date'])->locale('ja')->isoFormat('Y年M月D日 (ddd)') }}
                            {{ $reservation_data['visit_time'] }}
                        </td>
                    </tr>
                    <tr>
                        <td class="reservation-label">来店人数</td>
                        <td class="reservation-value">{{ $reservation_data['number_of_guests'] }}名</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 予約料金 -->
        <div class="reservation-card">
            <div class="reservation-header">予約料金</div>
            <table class="reservation-table">
                <tbody>
                    <tr>
                        <td class="reservation-label">予約料金</td>
                        <td class="reservation-value">{{ number_format($reservation_data['reservation_fee']) }}P</td>
                    </tr>
                    <tr>
                        <td class="reservation-label">ポイント残高</td>
                        <td class="reservation-value">{{ number_format(Auth::user()->point) }}P</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <reservation-confirmation :visit-date="'{{ $reservation_data['visit_date'] }}'" :visit-time="'{{ $reservation_data['visit_time'] }}'" :number-of-guests="{{ $reservation_data['number_of_guests'] }}" :reservation-fee="{{ $reservation_data['reservation_fee'] }}" :restaurant-id="{{ $reservation_data['restaurant_id'] }}">
        </reservation-confirmation>

    </div>
</div>
@endsection