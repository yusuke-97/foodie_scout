@extends('layouts.app')

@section('content')

<div class="mt-5" style="width: 961px; margin: 0 auto;">
    <div class="row">
        <div class="col-9">
            <div class="mb-3">
                <span style="background-color: #0fbe9f; color: #ffffff; padding: 4px 8px; border-radius: 4px;">公式</span>
            </div>
            <h2 style="font-weight: bold; margin-bottom: 8px;">
                {{$restaurant->name}}
            </h2>
            <div class="d-flex mb-2">
                <h3 style="color: #FFA500;" class="me-3">★★★★★</h3>
                <h3 style="color: red; font-weight: bold;">5.00</h3>
            </div>
            <p>
                {{$restaurant->description}}
            </p>
            <div class="d-flex mb-2">
                <p class="me-3">
                    <strong>最寄駅：</strong>{{$restaurant->nearest_station}}駅
                </p>
                <p class="me-3">
                    <strong>ジャンル：</strong>{{$restaurant->category->name}}
                </p>
                <p>
                    <strong>予算：</strong>￥{{$restaurant->price}}
                </p>
            </div>
        </div>
        <div class="col-3">
            <favorite-button :is-favorited="{{ $restaurant->isFavoritedBy(Auth::user()) ? 'true' : 'false' }}" :restaurant-id="{{ $restaurant->id }}"></favorite-button>
        </div>
    </div>
</div>




<div class="mt-5" style="width: 961px; margin: 0 auto;">
    <div class="row">
        <div class="col-8">
            <img src="{{ asset($restaurant->image) }}" style="width: 100%; height: auto;">
        </div>
        <div class="col-4" style="position: sticky; top: 0;">
            <reservation :restaurant-id="{{ $restaurant->id }}" :restaurant-name="'{{ $restaurant->name }}'" :restaurant-price="{{ $restaurant->price }}" :img-src="'{{ asset('img/foodie3.jpg') }}'">
            </reservation>
        </div>
        <div class="col-4">
            @auth
            <form class="m-3 align-items-end">
                @csrf
                <input type="hidden" name="id" value="{{$restaurant->id}}">
                <input type="hidden" name="name" value="{{$restaurant->name}}">
                <input type="hidden" name="price" value="{{$restaurant->price}}">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('restaurant.reservations', ['restaurant' => $restaurant->id]) }}" class="btn reservation-button text-dark w-100">
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