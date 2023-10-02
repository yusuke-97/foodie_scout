@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <!-- デスクトップ用プロフィール -->
    <div class="row">

        <!-- 左側のカラム：プロフィール画像とユーザー名表示エリア -->
        <div class="col-4 text-center">
            @if($user->profile_image)
            <!-- プロフィール画像の表示 -->
            <img class="profile-image" src="{{ asset('profile_images/' . $user->profile_image) }}" alt="プロフィール画像">
            @else
            <!-- プロフィール画像がない場合のアイコン表示 -->
            <i class="fas fa-user profile-icon"></i>
            @endif

            <!-- ユーザー名の表示 -->
            <p class="user-name mt-3" style="font-weight: bold;">{{ "@" . $user->user_name }}</p>
        </div>

        <!-- 右側のカラム：ユーザーの詳細情報表示エリア -->
        <div class="col-8">
            <div class="d-flex align-items-center justify-content-between">

                <!-- ユーザーの本名表示 -->
                <p class="mb-0 mr-2" style="font-weight: bold;">{{ $user->name }}</p>

                <medal-color :user-followed="{{ $user->followers->count() }}">
                </medal-color>

            </div>

            <!-- ユーザーのフォロー、フォロワー、投稿数情報 -->
            <div class="d-flex justify-content-between mt-2">

                <!-- フォロワー数 -->
                <p>
                    フォロワー
                    <strong>{{ $user->followers->count() }}</strong>
                    人
                </p>

                <!-- 来店数 -->
                <p>
                    来店数
                    <strong>{{ $user->reservations->count() }}</strong>
                </p>

                <!-- 予約数 -->
                <p>
                    予約数
                    <strong>{{ $user->reservations->count() }}</strong>
                </p>

            </div>
        </div>
    </div>
</div>
@endsection