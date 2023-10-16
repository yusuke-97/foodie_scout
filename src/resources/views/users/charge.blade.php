@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <div class="w-50">
        <point-charge :is-registered="'{{ Auth::user()->token }}'"></point-charge>
    </div>
</div>
@endsection