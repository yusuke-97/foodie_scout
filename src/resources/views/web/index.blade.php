@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories, 'major_category_names' => $major_category_names])
        @endcomponent
    </div>
    <div class="col-9">
        <h1>おすすめ店舗</h1>
        <div class="row">
            <div class="col-4">
                <a href="#">
                    <img src="{{ asset('img/foodie3.jpg') }}" class="img-thumbnail">
                </a>
                <div class="row">
                    <div class="col-12">
                        <p class="restaurant-label mt-2">
                            Hanam BBQ<br>
                            <label>￥3000</label>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <a href="#">
                    <img src="{{ asset('img/foodie3.jpg') }}" class="img-thumbnail">
                </a>
                <div class="row">
                    <div class="col-12">
                        <p class="restaurant-label mt-2">
                            一蘭<br>
                            <label>￥1000</label>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <a href="#">
                    <img src="{{ asset('img/foodie3.jpg') }}" class="img-thumbnail">
                </a>
                <div class="row">
                    <div class="col-12">
                        <p class="restaurant-label mt-2">
                            ひょうたん<br>
                            <label>￥1500</label>
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <h1>新店舗</h1>
        <div class="row">
            <div class="col-3">
                <a href="#">
                    <img src="{{ asset('img/foodie3.jpg') }}" class="img-thumbnail">
                </a>
                <div class="row">
                    <div class="col-12">
                        <p class="restaurant-label mt-2">
                            天下一品<br>
                            <label>￥1000</label>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <a href="#">
                    <img src="{{ asset('img/foodie3.jpg') }}" class="img-thumbnail">
                </a>
                <div class="row">
                    <div class="col-12">
                        <p class="restaurant-label mt-2">
                            マクドナルド<br>
                            <label>￥1000</label>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <a href="#">
                    <img src="{{ asset('img/foodie3.jpg') }}" class="img-thumbnail">
                </a>
                <div class="row">
                    <div class="col-12">
                        <p class="restaurant-label mt-2">
                            ケンタッキー<br>
                            <label>￥1000</label>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <a href="#">
                    <img src="{{ asset('img/foodie3.jpg') }}" class="img-thumbnail">
                </a>
                <div class="row">
                    <div class="col-12">
                        <p class="restaurant-label mt-2">
                            スシロー<br>
                            <label>￥2000</label>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <h1>人気ユーザー</h1>
        <div class="row">

        </div>
    </div>
</div>
@endsection