@extends('layouts.app')

@section('content')

<style>
    .reservation-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .reservation-header {
        font-size: 24px;
        border-bottom: 2px solid #333;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .reservation-section {
        margin-bottom: 20px;
    }

    .reservation-label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .reservation-value {
        font-size: 18px;
    }
</style>

<div class="reservation-container">
    <div class="reservation-header">
        {{ $reservationData['restaurant_name'] ?? '店舗名' }}
    </div>
    <div class="reservation-section">
        <div class="reservation-label">予約者情報</div>
        <div class="reservation-value">{{ $reservationData['name'] ?? '名前' }}</div>
        <div class="reservation-value">{{ $reservationData['phone_number'] ?? '電話番号' }}</div>
        <div class="reservation-value">{{ $reservationData['email'] ?? 'メールアドレス' }}</div>
    </div>
    <div class="reservation-section">
        <div class="reservation-label">予約確認</div>
        <div class="reservation-value">来店日時: {{ $reservationData['visit_date'] ?? '日付' }} {{ $reservationData['visit_time'] ?? '時間' }}</div>
        <div class="reservation-value">来店人数: {{ $reservationData['number_of_guests'] ?? '人数' }} 人</div>
    </div>
</div>

@endsection