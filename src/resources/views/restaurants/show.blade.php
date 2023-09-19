@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center">
    <div class="row w-75">
        <div class="col-5 offset-1">
            <img src="{{ asset('img/foodie3.jpg')}}" class="w-100 img-fluid">
        </div>
        <div class="col">
            <div class="d-flex flex-column">
                <h1 class="">
                    {{$restaurant->name}}
                </h1>
                <p class="">
                    {{$restaurant->description}}
                </p>
                <hr>
                <p class="d-flex align-items-end">
                    ￥{{$restaurant->price}}(税込)
                </p>
                <hr>
            </div>
            @auth
            <form class="m-3 align-items-end">
                @csrf
                <input type="hidden" name="id" value="{{$restaurant->id}}">
                <input type="hidden" name="name" value="{{$restaurant->name}}">
                <input type="hidden" name="price" value="{{$restaurant->price}}">
                <div class="row">
                    <div class="col-6">
                        <favorite-button :initial-is-favorited="{{ $restaurant->isFavoritedBy(Auth::user()) ? 'true' : 'false' }}" :restaurant-id="{{ $restaurant->id }}"></favorite-button>
                    </div>
                    <div class="col-6">
                        <a href="/restaurants/{{ $restaurant->id }}/favorite" class="btn favorite-button text-dark w-100">
                            <i class="fas fa-utensils"></i>
                            予約
                        </a>
                    </div>
                </div>
            </form>
            @endauth
        </div>

        <div class="offset-1 col-11">
            <hr class="w-100">
            <h3 class="float-left">カスタマーレビュー</h3>
        </div>

        <div class="offset-1 col-10">
            <!-- レビューを実装する箇所になります -->
        </div>
    </div>
</div>
@endsection