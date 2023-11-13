@extends('layouts.app')

@section('content')
    <div class="container row d-flex justify-content-center mt-3">
        <div class="col-12 col-md-6">
            <point-charge :is-registered="'{{ Auth::user()->token }}'"></point-charge>
        </div>
    </div>
@endsection