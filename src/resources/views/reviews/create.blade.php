@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <review-create :csrf="'{{ csrf_token() }}'" :restaurant-name="'{{ $restaurant->name }}'" :restaurant-id="{{ $restaurant->id }}"></review-create>
        </div>
    </div>
</div>
@endsection