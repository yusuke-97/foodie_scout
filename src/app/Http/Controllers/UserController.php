<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();

        return view('users.mypage', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->input('imageRemoved') === "true") {
            $user->image = null;
        } elseif ($request->hasFile('profileImage')) {
            $file = $request->file('profileImage');
            $path = Storage::disk('public')->put('profile_images', $file);
            $imagePath = "/storage/" . $path;
            $user->image = basename($imagePath);
        }

        $user->name = $request->input('name');
        $user->user_name = $request->input('userName');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone');

        $user->update();

        return redirect()->route('mypage');
    }

    // パスワード変更画面
    public function edit_password()
    {
        return view('users.edit_password');
    }

    // パスワード変更機能
    public function update_password(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if ($request->input('password') == $request->input('password_confirmation')) {
            $user->password = bcrypt($request->input('password'));
            $user->update();
        } else {
            return to_route('mypage.edit_password');
        }

        return to_route('mypage');
    }

    public function favorite()
    {
        $user = Auth::user();

        $favorites = $user->favorites(Restaurant::class)->paginate(10);

        return view('users.favorite', compact('favorites'));
    }

    public function reservation_history_index()
    {
        $user = Auth::user();

        // 予約を日付と時間で降順に並び替え
        $reservations = $user->reservations()->orderBy('visit_date', 'desc')
        ->orderBy('visit_time', 'desc')
        ->paginate(10);

        return view('users.reservation_history_index', compact('reservations'));
    }

    public function reservation_history_show(Reservation $reservation)
    {
        return view('users.reservation_history_show', compact('reservation'));
    }

    public function charge_page()
    {
        return view('users.charge');
    }

    public function charge_point(Request $request)
    {
        $charge_point = $request->input('point');
        $user = Auth::user();
        $user->point += $charge_point;
        $user->save();

        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        $res = \Payjp\Charge::create(
            [
                "customer" => $user->token,
                "amount" => $charge_point,
                "currency" => 'jpy'
            ]
        );

        return response()->json([
            'redirect_to' => route('mypage')
        ]);
    }

    public function profile(User $user)
    {
        $reviews = $user->reviews()
            ->where('score', '>=', 3)
            ->with('category', 'restaurant')
            ->get()
            ->groupBy('category_id')
            ->transform(function ($reviews) {
                return $reviews->sortByDesc('score')->take(3);
            });

        return view('users.profile', compact('user', 'reviews'));
    }

    public function follow(User $user)
    {
        Auth::user()->follow($user);

        return response()->json(['status' => 'follow']);
    }

    public function unfollow(User $user)
    {
        Auth::user()->unfollow($user);

        return response()->json(['status' => 'unfollow']);
    }

    public function register_card(Request $request)
    {
        $user = Auth::user();

        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        $card = [];
        $count = 0;

        if ($user->token != "") {
            $result = \Payjp\Customer::retrieve($user->token)->cards->all(array("limit" => 1))->data[0];
            $count = \Payjp\Customer::retrieve($user->token)->cards->all()->count;

            $card = [
                'brand' => $result["brand"],
                'exp_month' => $result["exp_month"],
                'exp_year' => $result["exp_year"],
                'last4' => $result["last4"]
            ];
        }

        return view('users.register_card', compact('card', 'count'));
    }

    public function token(Request $request)
    {
        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        $user = Auth::user();
        $customer = $user->token;

        if ($customer != "") {
            $cu = \Payjp\Customer::retrieve($customer);
            $delete_card = $cu->cards->retrieve($cu->cards->data[0]["id"]);
            $delete_card->delete();
            $cu->cards->create(array(
                "card" => request('payjp-token')
            ));
        } else {
            $cu = \Payjp\Customer::create(array(
                "card" => request('payjp-token')
            ));
            $user->token = $cu->id;
            $user->update();
        }

        return to_route('mypage');
    }
}
