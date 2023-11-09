<div class="container" style="margin-top: 30px; margin-bottom: 20px;">
    <h2 style="font-weight: bold;">料理ジャンルから探す</h2>
</div>
<div class="container" style="display: flex; flex-direction: row; justify-content: space-between; flex-wrap: wrap;">
    @foreach ($major_categories as $major_category)
    <div class=" col-12 col-md-6 p-4">
        <h3 style="font-weight: bold;">{{ $major_category->name }}</h3>
        <div class="row">
            @foreach ($categories as $category)
            @if ($category->major_category_id === $major_category->id)
            <div class="col">
                <div class="ratio ratio-1x1" style="position: relative;">
                    <a href="{{ route('restaurants.index', ['category' => $category->id]) }}" class="restaurant-image-link" style="display: block;">
                        <img src="{{ asset('img/foodie_' . $category->id . '.jpg') }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover;" />
                        <span>{{ $category->name }}</span>
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>