@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="row">
                <!-- プロフィール画像とユーザー名表示エリア -->
                <div class="col-4">
                    <div id="profile-image-container">
                        @if($user->image)
                        <img class="profile-image" src="{{ asset('/storage/profile_images/' . $user->image) }}" alt="プロフィール画像">
                        @else
                        <i class="fas fa-user profile-icon"></i>
                        @endif
                    </div>
                    <p class="mt-2" style="font-weight: bold;">{{ "@" . $user->user_name }}</p>
                </div>

                <!-- ユーザーの詳細情報表示エリア -->
                <div class="col-8">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h4 class="mb-0 mr-2" style="font-weight: bold;">{{ $user->name }}</h4>
                        <medal-color :user-followed="{{ $user->followers->count() }}"></medal-color>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <!-- フォロワー数 -->
                        <div class="text-center">
                            <div>フォロワー</div>
                            <div><strong>{{ $user->followers->count() }}</strong></div>
                        </div>

                        <!-- 行ったお店 -->
                        <div class="text-center">
                            <div>行ったお店</div>
                            <div><strong>{{ $user->reservations->count() }}</strong></div>
                        </div>

                        <!-- 予約数 -->
                        <div class="text-center">
                            <div>予約数</div>
                            <div><strong>{{ $user->reservations->count() }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection