@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > 会員情報の編集
            </span>

            <h1 class="mt-3 mb-3">会員情報の編集</h1>
            <hr>

            <form method="POST" action="{{ route('mypage') }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="image" class="text-md-left edit-user-info-label">プロフィール画像</label>
                    </div>
                    <div class="collapse show editUserName">
                        @if ($user->profile_image)
                        <img class="edit-profile-image" id="currentProfileImage" src="{{ Storage::disk('s3')->url('profile_images/' . Auth::user()->profile_image) }}" alt="プロフィール画像" width="100">
                        @else
                        <i class="fas fa-user fa-2x edit-profile-icon"></i>
                        @endif
                        <input type="file" class="custom-file-input" id="profile_image" name="profile_image" style="display: none;">
                        <a id="customProfile" href="#" class="text-primary" style="text-decoration: none; font-size: 80%; margin-left: 16px; font-weight: bold;">プロフィール画像を変更</a>
                        <a id="deleteProfileImage" href="#" class="text-danger" style="text-decoration: none; font-size: 80%; margin-left: 16px; font-weight: bold;">プロフィール画像を削除</a>
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="name" class="text-md-left edit-user-info-label">氏名</label>
                    </div>
                    <div class="collapse show editName">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus placeholder="侍 太郎">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>氏名を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="user_name" class="text-md-left edit-user-info-label">ユーザー名</label>
                    </div>
                    <div class="collapse show editUserName">
                        <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ $user->user_name }}" required autocomplete="user_name" autofocus placeholder="侍 太郎">
                        @error('user_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>ユーザー名を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="email" class="text-md-left edit-user-info-label">メールアドレス</label>
                    </div>
                    <div class="collapse show editUserMail">
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus placeholder="samurai@samurai.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>メールアドレスを入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="phone_number" class="text-md-left edit-user-info-label">電話番号</label>
                    </div>
                    <div class="collapse show editUserPhone">
                        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ $user->phone_number }}" required autocomplete="phone_number" autofocus placeholder="XXX-XXXX-XXXX">
                        @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>電話番号を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn submit-button mt-3 w-25">
                    保存
                </button>
            </form>
        </div>
    </div>
</div>
@endsection