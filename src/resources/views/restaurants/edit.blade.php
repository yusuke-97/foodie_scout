@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報更新</h1>

    <form action="{{ route('restaurants.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>店舗名</label>
            <input type="text" name="name" class="form-control" value="{{ $restaurant->name }}">
        </div>
        <div class="form-group">
            <label>店舗画像</label>
            <image-edit v-model="image" :initial-image="'{{ asset($restaurant->image) }}'"></image-edit>
        </div>
        <div class="form-group">
            <label>説明</label>
            <textarea name="description" class="form-control">{{ $restaurant->description }}</textarea>
        </div>
        <div class="form-group">
            <label>1人当たりの価格</label>
            <input type="number" name="price" class="form-control" value="{{ $restaurant->price }}">
        </div>
        <div class="form-group">
            <label>座席数</label>
            <input type="number" name="seat" class="form-control" value="{{ $restaurant->seat }}">
        </div>
        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postcode" class="form-control" value="{{ $restaurant->postcode }}">
        </div>
        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" class="form-control" value="{{ $restaurant->address }}">
        </div>
        <div class="form-group">
            <label>電話番号</label>
            <input type="text" name="phone_number" class="form-control" value="{{ $restaurant->phone_number }}">
        </div>
        <div class="form-group">
            <label>ジャンル</label>
            <select name="category_id" class="form-control">
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

    <a href="{{ route('restaurants.index') }}">店舗一覧に戻る</a>
</div>
@endsection