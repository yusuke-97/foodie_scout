@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <restaurant-ranking 
                :categories="{{ json_encode($categories) }}"
                :reservations="{{ json_encode($reservationsArray) }}"
            >
            </restaurant-ranking>
        </div>
    </div>
</div>
@endsection