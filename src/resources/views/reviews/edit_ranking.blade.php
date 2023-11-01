@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <restaurant-edit-ranking :category-name="'{{ $category->name }}'" :category-id="{{ $category->id }}" :reservations="Object.values({{ json_encode($reservations) }})" :reviews="{{ json_encode($reviews) }}"></restaurant-edit-ranking>
        </div>
    </div>
</div>
@endsection