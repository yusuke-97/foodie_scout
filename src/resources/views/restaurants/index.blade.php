@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-9">
        <div class="container mt-4">
            <div class="row w-100">
                @foreach($restaurants as $restaurant)
                <div class="col-3">
                    <a href="{{route('restaurants.show', $restaurant)}}">
                        <img src="{{ asset('img/foodie3.jpg')}}" class="img-thumbnail">
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="restaurant-label mt-2">
                                {{$restaurant->name}}<br>
                                <label>￥{{$restaurant->price}}</label>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{ $restaurants->links() }}
    </div>
</div>
@endsection