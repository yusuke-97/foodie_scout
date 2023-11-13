@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 30px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <restaurant-edit-ranking :category-name="'{{ $category->name }}'" :category-id="{{ $category->id }}" :reservations="Object.values({{ json_encode($reservations) }})" :reviews="{{ json_encode($reviews) }}"></restaurant-edit-ranking>
            </div>
        </div>
    </div>
@endsection