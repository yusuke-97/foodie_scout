<div>
    <h2>Edit Restaurant</h2>
</div>
<div>
    <a href="{{ route('restaurants.index') }}"> Back</a>
</div>

<form action="{{ route('restaurants.update',$restaurant->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <strong>店舗名</strong>
        <input type="text" name="name" value="{{ $restaurant->name }}" placeholder="Name">
    </div>
    <div>
        <strong>説明</strong>
        <textarea style="height:150px" name="description" placeholder="description">{{ $restaurant->description }}</textarea>
    </div>
    <div>
        <strong>1人当たりの価格</strong>
        <input type="number" name="price" value="{{ $restaurant->price }}">
    </div>
    <div>
        <strong>座席数</strong>
        <input type="number" name="seat" value="{{ $restaurant->seat }}" placeholder="Seat">
    </div>
    <div>
        <strong>郵便番号</strong>
        <input type="text" name="postcode" value="{{ $restaurant->postcode }}" placeholder="Postcode">
    </div>
    <div>
        <strong>住所</strong>
        <input type="text" name="address" value="{{ $restaurant->address }}" placeholder="Address">
    </div>
    <div>
        <strong>電話番号</strong>
        <input type="text" name="phone_number" value="{{ $restaurant->phone_number }}" placeholder="Phone Number">
    </div>
    <div>
        <strong>ジャンル</strong>
        <select name="category_id">
            @foreach ($categories as $category)
            @if ($category->id == $restaurant->category_id)
            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
            @else
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div>
        <button type="submit">Submit</button>
    </div>

</form>