@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories, 'major_category_names' => $major_category_names])
        @endcomponent
    </div>
    <div class="col-9">
        <div class="container">
            @if ($category !== null)
            <a href="{{ route('restaurants.index') }}">トップ</a> > <a href="#">{{ $category->major_category_name }}</a> > {{ $category->name }}
            <h1>{{ $category->name }}の店舗一覧{{$total_count}}件</h1>
            @endif
        </div>
        <div>
            Sort By
            @sortablelink('id', 'ID')
            @sortablelink('price', 'Price')
        </div>
        <div class="container mt-4">
            <div class="row w-100">
                @foreach($restaurants as $restaurant)
                <div class="col-3">
                    <a href="{{route('restaurants.show', $restaurant)}}">
                        <img src="{{ asset($restaurant->image) }}" class="img-thumbnail">
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
        {{ $restaurants->appends(request()->query())->links() }}
    </div>
</div>
@endsection