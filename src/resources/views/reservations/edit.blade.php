@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center" style="margin-top: 30px;">
        <div class="col-12 col-lg-9">

            <div class="main-header">
                {{ $reservation->restaurant->name }}
            </div>

            <!-- 予約内容確認 -->
            <div class="reservation-card">
                <div class="reservation-header">予約内容（変更前）</div>
                <table class="reservation-table">
                    <tbody>
                        <tr>
                            <td class="reservation-label">お名前</td>
                            <td class="reservation-value">{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td class="reservation-label">来店日時</td>
                            <td class="reservation-value">
                                {{ \Carbon\Carbon::parse($reservation->visit_date)->locale('ja')->isoFormat('Y年M月D日 (ddd)') }}
                                {{ \Carbon\Carbon::parse($reservation->visit_time)->format('H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="reservation-label">来店人数</td>
                            <td class="reservation-value">{{ $reservation->number_of_guests }}名</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3 style="font-weight: bold;" class="mb-3">予約変更</h3>

            <reservation-edit 
                google-api-key="{{ ENV('GOOGLE_API_KEY') }}"
                :restaurant-id="{{ $reservation->restaurant->id }}"
                :restaurant-name="'{{ $reservation->restaurant->name }}'"
                :restaurant-price="{{ $reservation->restaurant->price }}"
                :restaurant-seat="{{ $reservation->restaurant->seat }}"
                :restaurant-phone-number="'{{ $reservation->restaurant->phone_number }}'"
                :restaurant-start-time="'{{ $reservation->restaurant->start_time }}'"
                :restaurant-end-time="'{{ $reservation->restaurant->end_time }}'"
                :restaurant-closed-day="'{{ $reservation->restaurant->closed_day }}'"
                :user-point-balance="{{ Auth::user()->point }}"
                :reservation-id="{{ $reservation->id }}"
                :reservation-visit-date="'{{ $reservation->visit_date }}'"
                :reservation-visit-time="'{{ $reservation->visit_time }}'"
                :reservation-guests="{{ $reservation->number_of_guests }}">
            </reservation-edit>
        </div>
    </div>
@endsection