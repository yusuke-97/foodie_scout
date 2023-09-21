<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function restaurantReservation(Restaurant $restaurant)
    {
        return view('reservations.create', compact('restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // データの検証
        $request->validate([
            'visit_datetime' => 'required|date_format:"Y-m-d\TH:i"',
            'number_of_guests' => 'required|integer|min:1',
            'reservation_fee' => 'required|integer',
            'restaurant_id' => 'required|integer',
        ]);

        // データの保存
        $reservation = new Reservation();
        $reservation->visit_datetime = $request->input('visit_datetime');
        $reservation->number_of_guests = $request->input('number_of_guests');
        $reservation->reservation_fee = $request->input('reservation_fee');

        // その他のデータ
        $reservation->user_id = Auth::user()->id;
        $reservation->restaurant_id = $request->input('restaurant_id');

        $reservation->save();

        return response()->json([
            'message' => 'Reservation successful',
            'redirect_to' => '/users/mypage'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
