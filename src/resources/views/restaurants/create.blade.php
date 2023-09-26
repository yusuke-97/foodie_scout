@extends('layouts.app')

@section('content')
<div class="container">
    <h1>新しい店舗を追加</h1>

    <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="restaurant-name">店舗名</label>
            <input type="text" name="name" id="restaurant-name" class="form-control">
        </div>

        <div class="form-group">
            <image-upload v-model="image"></image-upload>
        </div>

        <div class="form-group">
            <label for="restaurant-description">説明</label>
            <textarea name="description" id="restaurant-description" class="form-control" style="resize: none;"></textarea>
        </div>
        <div class="form-group">
            <label for="restaurant-price">1人当たりの価格</label>
            <input type="number" name="price" id="restaurant-price" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-seat">座席数</label>
            <input type="number" name="seat" id="restaurant-seat" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-postcode">郵便番号</label>
            <input type="text" name="postcode" id="restaurant-postcode" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-address">住所</label>
            <input type="text" name="address" id="restaurant-address" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-phone">電話番号</label>
            <input type="text" name="phone_number" id="restaurant-phone" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-category">ジャンル</label>
            <select name="category_id" class="form-control" id="restaurant-category">
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">店舗を登録</button>
    </form>

    <a href="{{ route('restaurants.index') }}">店舗一覧に戻る</a>
</div>
@endsection