<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
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

        $user->name = $request->input('name') ? $request->input('name') : $user->name;
        $user->user_name = $request->input('user_name') ? $request->input('user_name') : $user->user_name;
        $user->email = $request->input('email') ? $request->input('email') : $user->email;
        $user->phone_number = $request->input('phone_number') ? $request->input('phone_number') : $user->phone_number;
        $user->update();

        return to_route('mypage');
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

        $favorites = $user->favorites(Restaurant::class)->get();

        return view('users.favorite', compact('favorites'));
    }

    public function reservation_history_index()
    {
        $user = Auth::user();
        $reservations = $user->reservations;
        return view('users.reservation_history_index', compact('reservations'));
    }

    public function reservation_history_show(Reservation $reservation)
    {
        return view('users.reservation_history_show', compact('reservation'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('users.profile', compact('user'));
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
}
