<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MajorCategory;
use App\Models\Restaurant;
use App\Models\User;

class WebController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $major_categories = MajorCategory::all();

        $recently_restaurants = Restaurant::selectRaw('*, COALESCE(average_rating, 0) as average_rating')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $recommend_restaurants = Restaurant::where('recommend_flag', true)->take(3)->get();

        $popular_users = User::withCount('followers')
            ->with(['reviews' => function ($query) {
                $query->where('score', '>', 0)
                    ->orderBy('score', 'desc')
                    ->take(3)
                    ->with('restaurant');
            }])
            ->orderBy('followers_count', 'desc')
            ->take(4)
            ->get();    

        return view('web.index', compact('major_categories', 'categories', 'recently_restaurants', 'recommend_restaurants', 'popular_users'));
    }
}