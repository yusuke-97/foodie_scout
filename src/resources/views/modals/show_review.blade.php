<div class="modal fade" id="showReviewModal{{ $review->id }}" tabindex="-1" aria-labelledby="showReviewLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row align-items-center" style="width: 100%;">
                    <div class="col-2">
                        <a href="{{ route('mypage.profile', $user->id) }}" id="small-profile-image-container" style="text-decoration: none;">
                            @if($user->image)
                            <img class="small-profile-image" src="{{ asset('/storage/profile_images/' . $user->image) }}" alt="プロフィール画像">
                            @else
                            <i class="fas fa-user small-profile-icon" style="color: #000000;"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col-10">
                        <a href="{{ route('mypage.profile', $user->id) }}" class="d-inline-block" style="text-decoration: none;">
                            <span style="font-weight: bold; color: #000000;" class="me-3">{{ $user->name }}</span>
                        </a>
                        <medal-color :user-followed="{{ $user->followers->count() }}" class="d-inline-block"></medal-color>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <a href="{{ route('restaurants.show', $review->restaurant) }}" style="text-decoration: none;">
                            <img src="/{{ $review->restaurant->image }}" style="width: 100px; height: 100px; object-fit: cover;">
                        </a>
                    </div>
                    <div class="col-8">
                        <a href="{{ route('restaurants.show', $review->restaurant) }}" style="text-decoration: none;">
                            <p style="color: #1E90FF; font-weight: bold; font-size: 16px;" class="mb-0">{{ $review->restaurant->name }}</p>
                        </a>
                        <p style="font-size: 12px;" class="mb-0">
                            <span>{{ $review->restaurant->nearest_station }}駅</span>
                            /
                            <span style="font-weight: bold;">{{ $review->restaurant->category->name }}</span>
                        </p>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                @for ($i = 1; $i <= 5; $i++) @if ($i <=round($review->restaurant->average_rating))
                                    <span style="color: #FFA500; font-size: 14px;">★</span>
                                    @else
                                    <span style="color: #DDDDDD; font-size: 14px;">★</span>
                                    @endif
                                    @endfor
                            </div>
                            <h3 class="mb-0" style="color: red; font-weight: bold; vertical-align: middle; font-size: 14px;">{{number_format($review->restaurant->average_rating, 2) }}</h3>
                        </div>
                        <i class="fa-solid fa-star"></i>
                        <span style="font-weight: bold; font-size: 14px;" class="ms-2">口コミ</span>
                        <p style="font-size: 12px;">{{ $review->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>