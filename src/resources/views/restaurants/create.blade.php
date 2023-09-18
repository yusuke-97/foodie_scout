<div>
    <h2>Add New Restaurant</h2>
</div>
<div>
    <a href="{{ route('restaurants.index') }}"> Back</a>
</div>

<form action="{{ route('restaurants.store') }}" method="POST">
    @csrf

    <div>
        <strong>店舗名</strong>
        <input type="text" name="name" placeholder="Name">
    </div>
    <div>
        <strong>説明</strong>
        <textarea style="height:150px" name="description" placeholder="Description"></textarea>
    </div>
    <div>
        <strong>1人当たりの価格</strong>
        <input type="number" name="price" placeholder="Price">
    </div>
    <div>
        <strong>座席数</strong>
        <input type="number" name="seat" placeholder="Seat">
    </div>
    <div>
        <strong>郵便番号</strong>
        <input type="text" name="postcode" placeholder="Postcode">
    </div>
    <div>
        <strong>住所</strong>
        <input type="text" name="address" placeholder="Address">
    </div>
    <div>
        <strong>電話番号</strong>
        <input type="text" name="phone_number" placeholder="Phone Number">
    </div>
    <div>
        <strong>ジャンル</strong>
        <select name="category_id">
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <button type="submit">Submit</button>
    </div>

</form>