@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <div class="w-75">
        <h1>予約画面</h1>

        <div class="row">
            <div class="offset-6 col-6">
                <div class="row">
                    <div class="col-4">
                        <h3 style="font-size: 18px; font-weight: bold; font-stretch: nomal; font-style: nomal; line-height: nomal; letter-spacing: 0.04px;">来店日時</h3>
                    </div>
                    <div class="col-4">
                        <h3 style="font-size: 18px; font-weight: bold; font-stretch: nomal; font-style: nomal; line-height: nomal; letter-spacing: 0.04px;">来店人数</h3>
                    </div>
                    <div class="col-4">
                        <h3 style="font-size: 18px; font-weight: bold; font-stretch: nomal; font-style: nomal; line-height: nomal; letter-spacing: 0.04px;">合計</h3>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <reservation :restaurant-id="{{ $restaurant->id }}" :restaurant-name="'{{ $restaurant->name }}'" :restaurant-price="{{ $restaurant->price }}" :img-src="'{{ asset('img/foodie3.jpg') }}'">
        </reservation>

    </div>
</div>
@endsection