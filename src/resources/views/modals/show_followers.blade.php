<div class="modal fade" id="showFollowersModal" tabindex="-1" aria-labelledby="showFollowersLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showFollowersLabel">フォロワー</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                @foreach($user->followers as $follower)
                <div class="row align-items-center mb-3" style="width: 100%;">
                    <div class="col-2">
                        <a href="{{ route('mypage.profile', $follower->id) }}" id="small-profile-image-container" style="text-decoration: none;">
                            @if($follower->image)
                                <img class="small-profile-image" src="{{ asset('/storage/profile_images/' . $follower->image) }}" alt="プロフィール画像">
                            @else
                                <i class="fas fa-user small-profile-icon" style="color: #000000;"></i>
                            @endif
                        </a>
                    </div>
                    @if(Auth::user()->id === $follower->id)
                        <div class="col-9">
                            <a href="{{ route('mypage.profile', $follower->id) }}" class="d-inline-block" style="text-decoration: none;">
                                <div style="font-weight: bold; color: #000000;">{{ $follower->name }}</div>
                                <div style="color: gray; font-size: 12px;">{{ $follower->user_name }}</div>
                            </a>
                        </div>
                    @else
                        <div class="col-5">
                            <a href="{{ route('mypage.profile', $follower->id) }}" class="d-inline-block" style="text-decoration: none;">
                                <div style="font-weight: bold; color: #000000;">{{ $follower->name }}</div>
                                <div style="color: gray; font-size: 12px;">{{ $follower->user_name }}</div>
                            </a>
                        </div>
                        <div class="col-4">
                            <follow-button :is-following="{{ Auth::user()->isFollowing($follower) ? 'true' : 'false' }}" :following-id="{{ $follower->id }}"></follow-button>
                        </div>
                    @endif
                    <div class="col-1">
                        <medal-color :user-followed="{{ $follower->followers->count() }}" class="d-inline-block"></medal-color>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>