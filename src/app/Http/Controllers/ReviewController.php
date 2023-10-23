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
        $rankings = $request->input('rankings');

        foreach ($rankings as $ranking) {
            $review = new Review();
            $review->content = $ranking['review'];
            $review->restaurant_id = $ranking['restaurantId'];
            $review->reservation_id = $ranking['reservationId'];
            $review->category_id = $ranking['categoryId'];
            $review->score = $ranking['score'];
            $review->user_id = Auth::user()->id;
            $review->save();
        }

        return response()->json([
            'redirect_to' => route('mypage.profile')
        ]);
    }

    public function restaurantRanking()
    {
        $user_id = Auth::user()->id;

        $now = Carbon::now();

        $reservations = Reservation::where('user_id', $user_id)
            ->where('visit_date', '<', $now)
            ->orWhere(function ($query) use ($now) {
                $query->where('visit_date', '=', $now->toDateString())
                    ->where('end_time', '<', $now->toTimeString());
            })
            ->with('restaurant.category')
            ->get()
            ->unique('restaurant_id');
            
        $reservationsArray = array_values($reservations->toArray());

        $categoriesCounts = $reservations
        ->pluck('restaurant.category')
        ->countBy('id');

        $reviewedCategoryIds = Review::where('user_id', $user_id)->pluck('category_id');

        $filteredCategoryIds = $categoriesCounts->filter(function ($count) {
            return $count >= 3;
        })->keys()->diff($reviewedCategoryIds);

        $categories = $reservations
        ->pluck('restaurant.category')
        ->unique('id')
        ->whereIn('id', $filteredCategoryIds)
        ->values();

        return view('reviews.ranking', compact('categories', 'reservationsArray'));
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
