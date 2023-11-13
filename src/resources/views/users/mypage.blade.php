@extends('layouts.app')

@section('content')
    <div class="row justify-content-center" style="margin-top: 30px;">
        <div class="col-12 col-md-8">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <h3 style="font-weight:bold; font-size: 24px;">マイページ</h3>

            <hr>

            <div class="container">
                <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        <i class="fas fa-user fa-3x"></i>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div class="d-flex flex-column">
                            <label class="mypage-label">会員情報</label>
                            <p class="mypage-content">アカウント情報の編集</p>
                        </div>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <a href="{{route('mypage.edit')}}">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr>

            <div class="container">
                <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        <i class="fas fa-credit-card fa-3x"></i>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div class="d-flex flex-column">
                            <label class="mypage-label">クレジットカード</label>
                            <p class="mypage-content">クレジットカードの登録</p>
                        </div>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <a href="{{route('mypage.register_card')}}">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr>

            <div class="container">
                <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        <i class="fas fa-utensils fa-3x"></i>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div class="d-flex flex-column">
                            <label class="mypage-label">予約履歴</label>
                            <p class="mypage-content">予約履歴の確認</p>
                        </div>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <a href="{{route('mypage.reservation_history')}}">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr>

            <div class="container">
                <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        <i class="fas fa-coins fa-3x"></i>
                    </div>
                    <div class="col-7 align-items-center">
                        <div class="d-flex flex-column">
                            <label class="mypage-label">ポイント</label>
                            <p class="mypage-content">
                                ポイント残高：
                                <span style="font-weight: bold; color: #0fbe9f">{{ number_format(Auth::user()->point) }}</span>P
                            </p>
                        </div>
                    </div>
                    <div class=" col-2 d-flex align-items-center">
                        <a href="{{route('charge.page')}}">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr>

            <div class="container">
                <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        <i class="fas fa-blog fa-3x"></i>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div class="d-flex flex-column">
                            <label class="mypage-label">プロフィール</label>
                            <p class="mypage-content">プロフィールの表示</p>
                        </div>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <a href="{{route('mypage.profile', Auth::user()->id)}}">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr>

            <div class="container">
                <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div class="d-flex flex-column">
                            <label class="mypage-label">パスワード変更</label>
                            <p class="mypage-content">パスワードの変更</p>
                        </div>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <a href="{{ route('mypage.edit_password') }}">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr>

            <div class="container">
                <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        <i class="fas fa-sign-out-alt fa-3x"></i>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div class="d-flex flex-column">
                            <label class="mypage-label">ログアウト</label>
                            <p class="mypage-content">ログアウトします</p>
                        </div>
                    </div>
                    <div class="col-2 d-flex align-items-center">
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