@extends('layouts.app')

@section('content')
    <div class="row justify-content-center" style="margin-top: 30px;">
        <div class="col-8">
            @if (isset($results))
                <h3 style="font-weight: bold; font-size: 24px;">{{ $area }}の{{ $category }}のお店</h3>
                
                @foreach ($results as $restaurant)
                    <hr>
                    <div style="margin-bottom: 20px;">
                        <div class="row">
                            <div class="col-5 col-md-4 col-lg-3">
                                <div class="ratio ratio-1x1">
                                    <a href="{{ route('restaurants.show', ['restaurant' => $restaurant['_source']['id']]) }}" class="restaurant-image-container">
                                        <img src="{{ $restaurant['_source']['image'] }}" alt="{{ $restaurant['_source']['name'] }}" class="restaurant-image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-7 col-md-8 col-lg-9">
                                <a href="{{ route('restaurants.show', ['restaurant' => $restaurant['_source']['id']]) }}" style="text-decoration: none;">
                                    <p class="restaurant-name">{{ $restaurant['_source']['name'] }}</p>
                                </a>
                                <p class="restaurant-info mb-0">
                                    <span>{{ $restaurant['_source']['nearest_station'] }}駅</span>
                                    /
                                    <span style="font-weight: bold;">{{ $category }}</span>
                                </p>
                                <hr class="mt-1 mb-1">
                                <p class="mb-0 restaurant-catchphrase">{{ $restaurant['_source']['catchphrase'] }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="restaurant-average-rating-star">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <=round($restaurant['_source']['average_rating']))
                                                <span style="color: #FFA500;">★</span>
                                            @else
                                                <span style="color: #DDDDDD;">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <h3 class="restaurant-average-rating-number">{{number_format($restaurant['_source']['average_rating'], 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <div class="d-flex justify-content-center">
                    {{ $results->links() }}
                </div>
            @else
                <h3>結果が見つかりませんでした</h3>
            @endif
        </div>
    </div>
@endsection