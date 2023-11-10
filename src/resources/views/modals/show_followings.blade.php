<div class="modal fade" id="showFollowingsModal" tabindex="-1" aria-labelledby="showFollowingsLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showFollowingsLabel">フォロー中</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                @foreach($user->followings as $following)
                <div class="row align-items-center mb-3" style="width: 100%;">
                    <div class="col-3">
                        <div class="ratio ratio-1x1">
                            <a href="{{ route('mypage.profile', App\Models\User::find($following->followable_id)->id) }}" class="small-profile-image-container" style="text-decoration: none;">
                                @if(App\Models\User::find($following->followable_id)->image)
                                <img class="profile-image" src="{{ asset('/storage/profile_images/' . App\Models\User::find($following->followable_id)->image) }}" alt="プロフィール画像">
                                @else
                                <i class="fas fa-user profile-icon" style="color: #000000;"></i>
                                @endif
                            </a>
                        </div>
                    </div>
                    @if(Auth::user()->id === App\Models\User::find($following->followable_id)->id)
                    <div class="col-8 p-0">
                        <a href="{{ route('mypage.profile', App\Models\User::find($following->followable_id)->id) }}" class="d-inline-block" style="text-decoration: none;">
                            <div class="follow-name">{{ App\Models\User::find($following->followable_id)->name }}</div>
                            <div class="follow-user-name">{{ App\Models\User::find($following->followable_id)->user_name }}</div>
                        </a>
                    </div>
                    @else
                    <div class="col-5 p-0">
                        <a href="{{ route('mypage.profile', App\Models\User::find($following->followable_id)->id) }}" class="d-inline-block" style="text-decoration: none;">
                            <div class="follow-name">{{ App\Models\User::find($following->followable_id)->name }}</div>
                            <div class="follow-user-name">{{ App\Models\User::find($following->followable_id)->user_name }}</div>
                        </a>
                    </div>
                    <div class="col-3 p-0">
                        <follow-button :is-following="{{ Auth::user()->isFollowing(App\Models\User::find($following->followable_id)) ? 'true' : 'false' }}" :following-id="{{ App\Models\User::find($following->followable_id)->id }}"></follow-button>
                    </div>
                    @endif
                    <div class="col-1">
                        <medal-color :user-followed="{{ App\Models\User::find($following->followable_id)->followers->count() }}" class="d-inline-block"></medal-color>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>