<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use App\Models\MajorCategory;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->category !== null) {
            $restaurants = Restaurant::where('category_id', $request->category)->sortable()->paginate(10);
            $total_count = Restaurant::where('category_id', $request->category)->count();
            $category = Category::find($request->category);
            $major_category = MajorCategory::find($category->major_category_id);
        } else {
            $restaurants = Restaurant::sortable()->paginate(10);
            $total_count = "";
            $category = null;
            $major_category = null;
        }
        $categories = Category::all();
        $major_categories = MajorCategory::all();

        return view('restaurants.index', compact('restaurants', 'category', 'major_category', 'categories', 'major_categories', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('restaurants.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'description' => 'required|max:255',
        ]);

        $restaurant = new Restaurant();
        $restaurant->name = $request->input('name');
        $restaurant->description = $request->input('description');
        $restaurant->price = $request->input('price');
        $restaurant->seat = $request->input('seat');
        $restaurant->postcode = $request->input('postcode');
        $restaurant->address = $request->input('address');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->category_id = $request->input('category_id');

        if ($request->file('image')) {
            $path = $request->file('image')->store('images', 'public');
            $restaurant->image = Storage::url($path);
        }

        $restaurant->save();

        return to_route('restaurants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        $reviews = Review::where('restaurant_id', $restaurant->id)
            ->with('user')
            ->get()
            ->sortByDesc(function ($review) {
                return $review->user->followers_count;
            })
            ->take(3);

        return view('restaurants.show', compact('restaurant', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        $categories = Category::all();

        return view('restaurants.edit', compact('restaurant', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {

        $restaurant->name = $request->input('name');
        $restaurant->description = $request->input('description');
        $restaurant->price = $request->input('price');
        $restaurant->seat = $request->input('seat');
        $restaurant->postcode = $request->input('postcode');
        $restaurant->address = $request->input('address');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->category_id = $request->input('category_id');

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'file|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);

            // 古い画像の削除
            if ($restaurant->image) {
                Storage::delete('public/images/' . $restaurant->image);
            }

            // 新しい画像の保存
            $path = $request->file('image')->store('images', 'public');
            $restaurant->image = Storage::url($path);
        }

        $restaurant->save();

        return redirect()->route('restaurants.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return to_route('restaurants.index');
    }

    public function addFavorite(Restaurant $restaurant)
    {
        Auth::user()->favorite($restaurant);

        // リクエストがAjaxの場合
        if (request()->ajax()) {
            return response()->json(['status' => 'added']);
        }

        // 通常のHTTPリクエストの場合
        return redirect()->back()->with('success', 'お気に入りに追加しました。');
    }

    public function removeFavorite(Restaurant $restaurant)
    {
        Auth::user()->unfavorite($restaurant);

        // リクエストがAjaxの場合
        if (request()->ajax()) {
            return response()->json(['status' => 'removed']);
        }

        // 通常のHTTPリクエストの場合
        return redirect()->back()->with('success', 'お気に入りを解除しました。');
    }

    public function search(Request $request) {
        $client = app('elasticsearch');
        
    }
}
