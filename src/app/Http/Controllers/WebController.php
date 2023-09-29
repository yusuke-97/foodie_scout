<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MajorCategory;
use App\Models\Restaurant;

class WebController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $major_categories = MajorCategory::all();

        $recently_restaurants = Restaurant::orderBy('created_at', 'desc')->take(4)->get();

        $recommend_restaurants = Restaurant::where('recommend_flag', true)->take(3)->get();

        return view('web.index', compact('major_categories', 'categories', 'recently_restaurants', 'recommend_restaurants'));
    }
}
