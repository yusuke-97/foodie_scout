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
                            <div class="col-5 col-md-4 col-lg-3">
                                <div class="ratio ratio-1x1">
                                    <a href="{{ route('restaurants.show', App\Models\Restaurant::find($fav->favoriteable_id)) }}" class="restaurant-image-container">
                                        <img src="{{ asset(App\Models\Restaurant::find($fav->favoriteable_id)->image) }}" class="restaurant-image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-7 col-md-8 col-lg-9">
                                <a href="{{ route('restaurants.show', App\Models\Restaurant::find($fav->favoriteable_id)) }}" style="text-decoration: none;">
                                    <p class="restaurant-name">{{ App\Models\Restaurant::find($fav->favoriteable_id)->name }}</p>
                                </a>
                                <p class="restaurant-info mb-0">
                                    <span>{{ App\Models\Restaurant::find($fav->favoriteable_id)->nearest_station }}駅</span>
                                    /
                                    <span style="font-weight: bold;">{{ App\Models\Restaurant::find($fav->favoriteable_id)->category->name }}</span>
                                </p>
                                <hr class="mt-1 mb-1">
                                <p class="mb-0 restaurant-catchphrase">{{ App\Models\Restaurant::find($fav->favoriteable_id)->catchphrase }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="restaurant-average-rating-star">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <=round(App\Models\Restaurant::find($fav->favoriteable_id)->average_rating))
                                                <span style="color: #FFA500;">★</span>
                                            @else
                                                <span style="color: #DDDDDD;">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <h3 class="restaurant-average-rating-number">{{number_format(App\Models\Restaurant::find($fav->favoriteable_id)->average_rating, 2) }}</h3>
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