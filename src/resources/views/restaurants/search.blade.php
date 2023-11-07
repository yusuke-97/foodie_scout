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
                    <div class="col-4">
                        <a href="{{ route('restaurants.show', ['restaurant' => $restaurant['_source']['id']]) }}" style="text-decoration: none;">
                            <img src="{{ $restaurant['_source']['image'] }}" alt="{{ $restaurant['_source']['name'] }}" style="width: 200px; height: 200px; object-fit: cover;">
                        </a>
                    </div>
                    <div class="col-8">
                        <a href="{{ route('restaurants.show', ['restaurant' => $restaurant['_source']['id']]) }}" style="text-decoration: none;">
                            <p style="color: #1E90FF; font-weight: bold; font-size: 24px;">{{ $restaurant['_source']['name'] }}</p>
                        </a>
                        <p>
                            <span>{{ $restaurant['_source']['nearest_station'] }}駅</span>
                            /
                            <span style="font-weight: bold;">{{ $category }}</span>
                        </p>
                        <hr>
                        <p class="mb-0">{{ $restaurant['_source']['catchphrase'] }}</p>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <=round($restaurant['_source']['average_rating']))
                                        <span style="color: #FFA500; font-size: 24px;">★</span>
                                    @else
                                        <span style="color: #DDDDDD; font-size: 24px;">★</span>
                                    @endif
                                @endfor
                            </div>
                            <h3 class="mb-0" style="color: red; font-weight: bold; vertical-align: middle;">{{number_format($restaurant['_source']['average_rating'], 2) }}</h3>
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