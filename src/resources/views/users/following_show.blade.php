@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <!-- デスクトップ用プロフィール -->
    <div class="row">

        <!-- 左側のカラム：プロフィール画像とユーザー名表示エリア -->
        <div class="col-4 text-center">
            @if($following->profile_image)
            <!-- プロフィール画像の表示 -->
            <img class="profile-image" src="{{ asset('profile_images/' . $following->profile_image) }}" alt="プロフィール画像">
            @else
            <!-- プロフィール画像がない場合のアイコン表示 -->
            <i class="fas fa-user"></i>
            @endif

            <!-- ユーザー名の表示 -->
            <p class="user-name mt-3" style="font-weight: bold;">{{ $following->user_name }}</p>
        </div>

        <!-- 右側のカラム：ユーザーの詳細情報表示エリア -->
        <div class="col-8">
            <div class="d-flex align-items-center justify-content-between">

                <!-- ユーザーの本名表示 -->
                <p class="mb-0 mr-2" style="font-weight: bold;">{{ $following->name }}</p>

                <medal-color :is-followed="{{ $following->followers->count() }}">
                </medal-color>

                <!-- 現在のユーザーが表示中のユーザー本人かどうかで表示を切り替え -->

                <follow-button :is-following="{{ Auth::user()->isFollowing($following) ? 'true' : 'false' }}" :following-id="{{ $following->id }}"></follow-button>

            </div>

            <!-- ユーザーのフォロー、フォロワー、投稿数情報 -->
            <div class="d-flex justify-content-between mt-2">

                <!-- フォロワー数 -->
                <p>
                    フォロワー
                    <strong>{{ $following->followers->count() }}</strong>
                    人
                </p>

                <!-- 来店数 -->
                <p>
                    来店数
                    <strong>{{ $following->reservations->count() }}</strong>
                </p>

                <!-- 予約数 -->
                <p>
                    予約数
                    <strong>{{ $following->reservations->count() }}</strong>
                </p>

            </div>
        </div>
    </div>
</div>
@endsection