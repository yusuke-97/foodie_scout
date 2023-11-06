@extends('layouts.app')

@section('content')
<div class="row justify-content-center" style="margin-top: 30px;">
    <div class="col-8">
        @if (isset($favorites))
        <h3 style="font-weight: bold; font-size: 24px;">お気に入りの店舗一覧</h3>
        @foreach ($favorites as $fav)
        <hr>
        <div style="margin-bottom: 20px;">
            <div class="row">
                <div class="col-4">
                    <img src="{{ asset(App\Models\Restaurant::find($fav->favoriteable_id)->image) }}" style="width: 200px; height: 200px; object-fit: cover;">
                </div>
                <div class="col-8">
                    <p style="color: #1E90FF; font-weight: bold; font-size: 24px;">{{ App\Models\Restaurant::find($fav->favoriteable_id)->name }}</p>
                    <p>
                        <span>{{ App\Models\Restaurant::find($fav->favoriteable_id)->nearest_station }}駅</span>
                        /
                        <span style="font-weight: bold;">{{ App\Models\Restaurant::find($fav->favoriteable_id)->category->name }}</span>
                    </p>
                    <hr>
                    <p class="mb-0">{{ App\Models\Restaurant::find($fav->favoriteable_id)->catchphrase }}</p>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            @for ($i = 1; $i <= 5; $i++) @if ($i <=round(App\Models\Restaurant::find($fav->favoriteable_id)->average_rating)) <span style="color: #FFA500; font-size: 24px;">★</span>
                                @else
                                <span style="color: #DDDDDD; font-size: 24px;">★</span>
                                @endif
                                @endfor
                        </div>
                        <h3 class="mb-0" style="color: red; font-weight: bold; vertical-align: middle;">{{number_format(App\Models\Restaurant::find($fav->favoriteable_id)->average_rating, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <form action="{{ route('restaurants.favorite', $fav->favoriteable_id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn submit-button" style="background-color: #f16363;">削除</button>
            </form>
        </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $favorites->links() }}
        </div>
        @else
        <h3>結果が見つかりませんでした</h3>
        @endif
    </div>
</div>
@endsection