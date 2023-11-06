<div class="container" style="margin-top: 30px; margin-bottom: 20px;">
    <h2 style="font-weight: bold;">料理ジャンルから探す</h2>
</div>
<div class="container" style="display: flex; flex-direction: row; justify-content: space-between; flex-wrap: wrap;">
    @foreach ($major_categories as $major_category)
    <div style="margin-bottom: 20px;">
        <h3 style="font-weight: bold;">{{ $major_category->name }}</h3>
        <div style="display: flex; flex-wrap: wrap;">
            @foreach ($categories as $category)
            @if ($category->major_category_id === $major_category->id)
            <div style="position: relative; margin-right: 10px;">
                <a href="{{ route('restaurants.index', ['category' => $category->id]) }}" class="restaurant-image-link" style="display: block;">
                    <img src="{{ asset('img/foodie_' . $category->id . '.jpg') }}" alt="{{ $category->name }}" style="width: 128px; height: 128px; object-fit: cover;" />
                    <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-weight: bold; font-size: 16px; white-space: nowrap;">{{ $category->name }}</span>
                </a>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>