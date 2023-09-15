<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        $user->name = $request->input('name') ? $request->input('name') : $user->name;
        $user->user_name = $request->input('user_name') ? $request->input('user_name') : $user->user_name;
        $user->email = $request->input('email') ? $request->input('email') : $user->email;
        $user->phone_number = $request->input('phone_number') ? $request->input('phone_number') : $user->phone_number;
        $user->update();

        return to_route('mypage');
    }
}
