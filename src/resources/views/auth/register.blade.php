@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 30px;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h3 class="mt-3 mb-3" style="font-weight: bold;">新規会員登録</h3>

            <hr>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row mb-2">
                    <label for="name" class="col-lg-6 col-form-label text-md-left">氏名<span class="ms-1 require-input-label"><span class="require-input-label-text">必須</span></span></label>

                    <div class="col-lg-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror login-input" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="氏名">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>氏名を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="user_name" class="col-lg-6 col-form-label text-md-left">ユーザー名<span class="ms-1 require-input-label"><span class="require-input-label-text">必須</span></span></label>

                    <div class="col-lg-6">
                        <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror login-input" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" autofocus placeholder="ユーザー名">

                        @error('user_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>氏名を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="email" class="col-lg-6 col-form-label text-md-left">メールアドレス<span class="ms-1 require-input-label"><span class="require-input-label-text">必須</span></span></label>

                    <div class="col-lg-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror login-input" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="foodie@example.com">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>メールアドレスを入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="phone_number" class="col-lg-6 col-form-label text-md-left">電話番号<span class="ms-1 require-input-label"><span class="require-input-label-text">必須</span></span></label>

                    <div class="col-lg-6">
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror login-input" name="phone_number" required placeholder="03-0000-0000">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="password" class="col-lg-6 col-form-label text-md-left">パスワード<span class="ms-1 require-input-label"><span class="require-input-label-text">必須</span></span></label>

                    <div class="col-lg-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror login-input" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="password-confirm" class="col-lg-6 col-form-label text-md-left">パスワード(確認用)<span class="ms-1 require-input-label"><span class="require-input-label-text">必須</span></span></label>

                    <div class="col-lg-6">
                        <input id="password-confirm" type="password" class="form-control login-input" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn submit-button w-100 mt-3">
                        アカウント作成
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection