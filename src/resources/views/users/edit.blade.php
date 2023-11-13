@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 30px;">
            <div class="col-12 col-md-6">
                <user-edit :csrf="'{{ csrf_token() }}'" :user-image="'{{ Auth::user()->image }}'" :full-name="'{{ Auth::user()->name }}'" :user-name="'{{ Auth::user()->user_name }}'" :user-email="'{{ Auth::user()->email }}'" :user-phone-number="'{{ Auth::user()->phone_number }}'"></user-edit>
            </div>
        </div>
    </div>
@endsection