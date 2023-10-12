@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <div class="w-50">
        <h4 class="mt-4 mb-4 sub-title" style="font-weight: bold;">
            <i class="fas fa-coins"></i>
            ポイントチャージ
        </h4>

        <form action="{{ route('charge.point') }}" method="POST">
            @csrf

            <input type="radio" name="point" value="1000" class="mb-3"><strong> 1,000</strong> ポイント<br>
            <input type="radio" name="point" value="2000" class="mb-3"><strong> 2,000</strong> ポイント<br>
            <input type="radio" name="point" value="5000" class="mb-3"><strong> 5,000</strong> ポイント<br>
            <input type="radio" name="point" value="10000" class="mb-3"><strong> 10,000</strong> ポイント<br>
            <input type="radio" name="point" value="30000" class="mb-3"><strong> 30,000</strong> ポイント<br>

            <button type="submit" class="btn submit-button mt-3">チャージする</button>
        </form>
    </div>
</div>
@endsection