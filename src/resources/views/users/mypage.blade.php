@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <div class="w-50">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif

        <h1>マイページ</h1>

        <hr>

        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <i class="fas fa-user fa-3x"></i>
                    </div>
                    <div class="col-9 d-flex align-items-center ms-3 mt-3">
                        <div class="d-flex flex-column">
                            <label style="font-weight: bold;">会員情報の編集</label>
                            <p>アカウント情報の編集</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{route('mypage.edit')}}">
                        <i class="fas fa-chevron-right fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr>

        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <i class="fas fa-credit-card fa-3x"></i>
                    </div>
                    <div class="col-9 d-flex align-items-center ms-3 mt-3">
                        <div class="d-flex flex-column">
                            <label style="font-weight: bold;">クレジットカードの登録</label>
                            <p>クレジットカードの登録</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{route('mypage.register_card')}}">
                        <i class="fas fa-chevron-right fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr>

        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <i class="fas fa-utensils fa-3x"></i>
                    </div>
                    <div class="col-9 d-flex align-items-center ms-3 mt-3">
                        <div class="d-flex flex-column">
                            <label style="font-weight: bold;">予約履歴</label>
                            <p>予約履歴を確認できます</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{route('mypage.reservation_history')}}">
                        <i class="fas fa-chevron-right fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr>

        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <i class="fas fa-coins fa-3x"></i>
                    </div>
                    <div class="col-9 d-flex align-items-center ms-3 mt-3">
                        <div class="d-flex flex-column">
                            <label style="font-weight: bold;">ポイント</label>
                            <p>ポイントをチャージできます</p>
                            <p>ポイント残高：<span style="font-weight: bold; color: #0fbe9f">{{ number_format(Auth::user()->point) }}</span>P</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{route('charge.page')}}">
                        <i class="fas fa-chevron-right fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr>

        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <i class="fas fa-blog fa-3x"></i>
                    </div>
                    <div class="col-9 d-flex align-items-center ms-3 mt-3">
                        <div class="d-flex flex-column">
                            <label style="font-weight: bold;">プロフィール</label>
                            <p>プロフィールを表示します</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{route('mypage.profile')}}">
                        <i class="fas fa-chevron-right fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr>

        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <div class="col-9 d-flex align-items-center ms-3 mt-3">
                        <div class="d-flex flex-column">
                            <label style="font-weight: bold;">パスワード変更</label>
                            <p>パスワードを変更します</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('mypage.edit_password') }}">
                        <i class="fas fa-chevron-right fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr>

        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <i class="fas fa-sign-out-alt fa-3x"></i>
                    </div>
                    <div class="col-9 d-flex align-items-center ms-3 mt-3">
                        <div class="d-flex flex-column">
                            <label style="font-weight: bold;">ログアウト</label>
                            <p>ログアウトします</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-chevron-right fa-2x"></i>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <hr>
    </div>
</div>
@endsection