@extends('layouts.app')

@section('content')
<div class="container  d-flex justify-content-center mt-3">
    <div class="w-75">
        <h1>お気に入り</h1>

        <hr>

        <div class="row">
            @foreach ($followings as $following)
            <div class="col-md-7 mt-2">
                <div class="d-inline-flex">
                    <a href="{{ route('following.show', ['following' => $following->followable->id]) }}" class="w-25">
                        @if($following->profile_image)
                        <!-- プロフィール画像の表示 -->
                        <img class="profile-image img-fluid w-100" src="{{ asset('profile_images/' . $following->profile_image) }}" alt="プロフィール画像">
                        @else
                        <!-- プロフィール画像がない場合のアイコン表示 -->
                        <i class="fas fa-user"></i>
                        @endif
                    </a>
                    <div class="container mt-3">
                        <h5 class="w-100 favorite-item-text">{{App\Models\User::find($following->followable_id)->name}}</h5>
                        <h6 class="w-100 favorite-item-text">{{App\Models\User::find($following->followable_id)->user_name}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-center justify-content-end">
                <form action="{{ route('unfollow', $following->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link favorite-item-delete">フォロー解除</button>
                </form>
            </div>
            @endforeach
        </div>

        <hr>
    </div>
</div>
@endsection