<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->category !== null) {
            $restaurants = Restaurant::where('category_id', $request->category)->sortable()->paginate(1);
            $total_count = Restaurant::where('category_id', $request->category)->count();
            $category = Category::find($request->category);
        } else {
            $restaurants = Restaurant::sortable()->paginate(1);
            $total_count = "";
            $category = null;
        }
        $categories = Category::all();
        $major_category_names = Category::pluck('major_category_name')->unique();

        return view('restaurants.index', compact('restaurants', 'category', 'categories', 'major_category_names', 'total_count'));
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
        return view('restaurants.show', compact('restaurant'));
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
        Log::info($request->all());

        $restaurant->name = $request->input('name');
        $restaurant->description = $request->input('description');
        $restaurant->price = $request->input('price');
        $restaurant->seat = $request->input('seat');
        $restaurant->postcode = $request->input('postcode');
        $restaurant->address = $request->input('address');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->category_id = $request->input('category_id');

        if ($request->hasFile('image')) {
            Log::info('File is uploaded.');
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
        } else {
            Log::info('No file uploaded.');
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
}
