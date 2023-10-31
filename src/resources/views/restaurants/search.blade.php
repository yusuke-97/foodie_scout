@extends('layouts.app')

@section('content')

<form action="{{ route('search') }}" method="get">
    <div>
        <label for="area">エリア・駅:</label>
        <input type="text" id="area" name="area">
    </div>
    <div>
        <label for="category">ジャンル:</label>
        <input type="text" id="category" name="category">
    </div>
    <div>
        <label for="visit_date">訪問日:</label>
        <input type="date" id="visit_date" name="visit_date">
    </div>
    <div>
        <label for="visit_time">訪問時刻:</label>
        <input type="time" id="visit_time" name="visit_time">
    </div>
    <div>
        <label for="number_of_guests">人数:</label>
        <input type="number" id="number_of_guests" name="number_of_guests" min="1">
    </div>
    <div>
        <button type="submit">検索</button>
    </div>
</form>

@if (isset($results))
<h3>検索結果</h3>
<ul>
    @foreach ($results as $restaurant)
    <li>{{ $restaurant['_source']['address'] }} - {{ $restaurant['_source']['nearest_station'] }} - {{ $restaurant['_source']['name'] }} - {{ $restaurant['_source']['category'] }}</li>
    @endforeach
</ul>
@endif
@endsection