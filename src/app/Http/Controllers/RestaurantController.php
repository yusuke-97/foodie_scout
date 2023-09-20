<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->category !== null) {
            $restaurants = Restaurant::where('category_id', $request->category)->paginate(5);
            $total_count = Restaurant::where('category_id', $request->category)->count();
            $category = Category::find($request->category);
        } else {
            $restaurants = Restaurant::paginate(5);
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
        $restaurant = new Restaurant();
        $restaurant->name = $request->input('name');
        $restaurant->description = $request->input('description');
        $restaurant->price = $request->input('price');
        $restaurant->seat = $request->input('seat');
        $restaurant->postcode = $request->input('postcode');
        $restaurant->address = $request->input('address');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->category_id = $request->input('category_id');
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
        $restaurant->name = $request->input('name');
        $restaurant->description = $request->input('description');
        $restaurant->price = $request->input('price');
        $restaurant->seat = $request->input('seat');
        $restaurant->postcode = $request->input('postcode');
        $restaurant->address = $request->input('address');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->category_id = $request->input('category_id');
        $restaurant->update();

        return to_route('restaurants.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return to_route('restaurants.index');
    }
}
