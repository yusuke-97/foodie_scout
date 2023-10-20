@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @foreach($categories as $category)
                <div>{{ $category->name }}</div>
            @endforeach
        </div>
    </div>
</div>
@endsection