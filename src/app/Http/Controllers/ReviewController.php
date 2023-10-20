<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Reservation $reservation)
    {
        return view('reviews.create', compact('reservation'));
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $review = new Review();
        $review->content = $request->input('content');
        $review->restaurant_id = $request->input('restaurant_id');
        $review->reservation_id = $request->input('reservation_id');
        $review->user_id = Auth::user()->id;
        $review->save();

        return redirect()->route('mypage');
    }

    public function restaurantRanking()
    {
        $user_id = Auth::user()->id;

        $now = Carbon::now(); // 現在の日時を取得

        $categories = Reservation::where('user_id', $user_id)
            ->where('visit_date', '<', $now)
            ->orWhere(function ($query) use ($now) {
                $query->where('visit_date', '=', $now->toDateString())
                    ->where('end_time', '<', $now->toTimeString());
            })
            ->with('restaurant.category')
            ->get()
            ->pluck('restaurant.category')
            ->unique('id')
            ->values();

        return view('reviews.ranking', compact('categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
