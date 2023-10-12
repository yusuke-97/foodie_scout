@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <h1>ポイントチャージ</h1>

    <form action="{{ route('charge.point') }}" method="POST">
        @csrf

        <input type="radio" name="point" value="1000"> 1000ポイント<br>
        <input type="radio" name="point" value="2000"> 2000ポイント<br>
        <input type="radio" name="point" value="5000"> 5000ポイント<br>
        <input type="radio" name="point" value="10000"> 10000ポイント<br>
        <input type="radio" name="point" value="30000"> 30000ポイント<br>

        <button type="submit">ポイントをチャージ</button>
    </form>
</div>
@endsection