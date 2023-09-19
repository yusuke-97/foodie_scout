@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報更新</h1>

    <form action="{{ route('restaurants.update',$restaurant->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="restaurant-name">店舗名</label>
            <input type="text" name="name" id="restaurant-name" class="form-control" value="{{ $restaurant->name }}">
        </div>
        <div class="form-group">
            <label for="restaurant-description">説明</label>
            <textarea name="description" id="restaurant-description" class="form-control">{{ $restaurant->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="restaurant-price">1人当たりの価格</label>
            <input type="number" name="price" id="restaurant-price" class="form-control" value="{{ $restaurant->price }}">
        </div>
        <div class="form-group">
            <label for="restaurant-seat">座席数</label>
            <input type="number" name="seat" id="restaurant-seat" class="form-control" value="{{ $restaurant->seat }}">
        </div>
        <div class="form-group">
            <label for="restaurant-postcode">郵便番号</label>
            <input type="text" name="postcode" id="restaurant-postcode" class="form-control" value="{{ $restaurant->postcode }}">
        </div>
        <div class="form-group">
            <label for="restaurant-address">住所</label>
            <input type="text" name="address" id="restaurant-address" class="form-control" value="{{ $restaurant->address }}">
        </div>
        <div class="form-group">
            <label for="restaurant-phone">電話番号</label>
            <input type="text" name="phone_number" id="restaurant-phone" class="form-control" value="{{ $restaurant->phone_number }}">
        </div>
        <div class="form-group">
            <label for="restaurant-category">ジャンル</label>
            <select name="category_id" class="form-control" id="restaurant-category">
                @foreach ($categories as $category)
                @if ($category->id == $restaurant->category_id)
                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                @else
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-danger">更新</button>
    </form>

    <a href="{{ route('restaurants.index') }}">商品一覧に戻る</a>
</div>
@endsection