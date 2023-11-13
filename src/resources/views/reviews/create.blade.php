@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 30px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <review-create :csrf="'{{ csrf_token() }}'" :restaurant-name="'{{ $reservation->restaurant->name }}'" :restaurant-id="{{ $reservation->restaurant->id }}" :reservation-id="{{ $reservation->id }}"></review-create>
            </div>
        </div>
    </div>
@endsection