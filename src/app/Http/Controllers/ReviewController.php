<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

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

        $user_id = Auth::user()->id;

        // categoryIdを取得
        $categoryId = $rankings[0]['categoryId'];

        // user_idとcategoryIdを持つ既存のrestaurantIdsを取得
        $existingRestaurantIds = Review::where('user_id', $user_id)
        ->where('category_id', $categoryId)
        ->pluck('restaurant_id')
        ->toArray();

        foreach ($rankings as $ranking) {
            if (in_array($ranking['restaurantId'], $existingRestaurantIds)) {
                // 既存のレビューを更新
                $existingReview = Review::where('user_id', $user_id)
                    ->where('restaurant_id', $ranking['restaurantId'])
                    ->where('category_id', $categoryId)
                    ->first();
                if ($existingReview) {
                    $existingReview->content = $ranking['review'];
                    $existingReview->score = $ranking['score'];
                    $existingReview->save();
                }
            } else {
                // 新しいレビューを登録
                $newReview = new Review();
                $newReview->content = $ranking['review'];
                $newReview->restaurant_id = $ranking['restaurantId'];
                $newReview->reservation_id = $ranking['reservationId'];
                $newReview->category_id = $categoryId;
                $newReview->score = $ranking['score'];
                $newReview->user_id = $user_id;
                $newReview->save();
            }
        }

        return response()->json([
            'redirect_to' => route('mypage.profile', ['user' => $user_id])
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

        $zeroScoreCategories = Review::where('user_id', $user_id)
            ->select('category_id')
            ->groupBy('category_id')
            ->havingRaw('MAX(score) = 0 AND MIN(score) = 0')
            ->pluck('category_id');
        
        $reviews = Review::where('user_id', $user_id)
            ->where('score', 0)
            ->whereIn('category_id', $zeroScoreCategories)
            ->get();

        $reviewedCategoryIds = Review::where('user_id', $user_id)->pluck('category_id');

        $filteredCategoryIds = $categoriesCounts->filter(function ($count) {
            return $count >= 3;
        })->keys()->diff($reviewedCategoryIds);

        $categoryIds = $filteredCategoryIds->merge($zeroScoreCategories)->unique();

        $categories = $reservations
            ->pluck('restaurant.category')
            ->unique('id')
            ->whereIn('id', $categoryIds)
            ->values();

        return view('reviews.ranking', compact('categories', 'reservationsArray', 'reviews'));
    }

    public function restaurantEditRanking(Category $category)
    {
        $now = Carbon::now();

        $reservations = Reservation::whereHas('restaurant.category', function ($query) use ($category) {
            $query->where('id', $category->id);
        })
        ->where('visit_date', '<', $now)
        ->orWhere(function ($query) use ($now) {
            $query->where('visit_date', '=', $now->toDateString())
                ->where('end_time', '<', $now->toTimeString());
        })
        ->with('restaurant.category')
        ->get()
        ->unique('restaurant_id');

        $reviews = Review::whereIn('reservation_id', $reservations->pluck('id'))
        ->orderBy('score', 'desc')
        ->get();

        return view('reviews.edit_ranking', compact('category', 'reservations', 'reviews'));
    }

    /**
     * Display the specified resource.
     */
    public function timeline()
    {
        // 現在認証されているユーザーを取得
        $user = Auth::user();

        // ユーザーがフォローしているユーザーのIDを取得
        $followings = DB::table('followables')
            ->where('user_id', $user->id)
            ->where('followable_type', 'App\Models\User')
            ->pluck('followable_id')
            ->push($user->id);


        // フォローしているユーザーのレビューを取得
        $reviews = Review::whereIn('user_id', $followings)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy('category_id');

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $rankings = $request->input('rankings');

        $user_id = Auth::user()->id;

        // categoryIdを取得
        $categoryId = $rankings[0]['categoryId'];

        // user_idとcategoryIdを持つ既存のrestaurantIdsを取得
        $existingRestaurantIds = Review::where('user_id', $user_id)
            ->where('category_id', $categoryId)
            ->pluck('restaurant_id')
            ->toArray();

        $newRestaurantIds = array_column($rankings, 'restaurantId');

        // 既存のrestaurantIdで新しいrestaurantIdsと一致しないものはscoreをnullにする
        Review::where('user_id', $user_id)
            ->where('category_id', $categoryId)
            ->whereNotIn('restaurant_id', $newRestaurantIds)
            ->update(['score' => 0]);

        foreach ($rankings as $ranking) {
            if (in_array($ranking['restaurantId'], $existingRestaurantIds)) {
                // 既存のレビューを更新
                $existingReview = Review::where('user_id', $user_id)
                    ->where('restaurant_id', $ranking['restaurantId'])
                    ->where('category_id', $categoryId)
                    ->first();
                if ($existingReview) {
                    $existingReview->content = $ranking['review'];
                    $existingReview->score = $ranking['score'];
                    $existingReview->save();
                }
            } else {
                // 新しいレビューを登録
                $newReview = new Review();
                $newReview->content = $ranking['review'];
                $newReview->restaurant_id = $ranking['restaurantId'];
                $newReview->reservation_id = $ranking['reservationId'];
                $newReview->category_id = $categoryId;
                $newReview->score = $ranking['score'];
                $newReview->user_id = $user_id;
                $newReview->save();
            }
        }

        return response()->json([
            'redirect_to' => route('mypage.profile', ['user' => $user_id])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteRanking(Request $request)
    {
        $category_id = $request->input('category_id');

        $user_id = Auth::user()->id;

        Review::where('user_id', $user_id)
            ->where('category_id', $category_id)
            ->update(['score' => 0]);

        return response()->json([
            'redirect_to' => route('mypage.profile', ['user' => Auth::user()->id])
        ]);
    }
}
