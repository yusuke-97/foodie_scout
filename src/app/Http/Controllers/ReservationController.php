<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

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
        // データの保存
        $reservation = new Reservation();
        $rawDate = $request->input('visit_date');
        $correctFormatDate = explode('T', $rawDate)[0];
        $reservation->visit_date = $correctFormatDate;

        $visitTime = $request->input('visit_time');
        $reservation->visit_time = $visitTime;

        $endTime = Carbon::createFromFormat('H:i', $visitTime)->addHour(1)->addMinutes(30)->format('H:i');
        $reservation->end_time = $endTime;

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

    public function availableSeatsForDay(Request $request)
    {
        $desiredDate = $request->input('visit_date');
        $desiredDate = Carbon::parse($desiredDate)->format('Y-m-d');

        $startBusinessHour = intval(substr($request->input('start_time'), 0, 2));
        $startBusinessMinute = intval(substr($request->input('start_time'), 3, 2));

        $endBusinessHour = intval(substr($request->input('end_time'), 0, 2));

        $results = [];

        for ($hour = $startBusinessHour; $hour < $endBusinessHour; $hour++) {
            for ($minute = $startBusinessMinute; $minute < 60; $minute += 30) {
                $desiredStartTime = sprintf('%02d:%02d', $hour, $minute);
                $desiredEndTime = Carbon::createFromFormat('H:i', $desiredStartTime)->addHour(1)->addMinutes(30)->format('H:i');

                $alreadyReservedSeats = Reservation::where('visit_date', $desiredDate)
                    ->where('restaurant_id', $request->input('restaurant_id'))
                    ->where(function ($query) use ($desiredStartTime, $desiredEndTime) {
                        $query->WhereBetween('end_time', [$desiredStartTime, $desiredEndTime]);
                    })
                    ->sum('number_of_guests');

                $results[$desiredStartTime] = $alreadyReservedSeats + $request->input('number_of_guests');
            }

            $startBusinessMinute = 0;
        }

        return response()->json(['reserved_seats' => $results]);
    }

    public function availableDaysForMonth(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        $restaurant_seat = $request->input('restaurant_seat');
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $dates = [];

        $startBusinessHour = intval(substr($request->input('start_time'), 0, 2));
        $startBusinessMinute = intval(substr($request->input('start_time'), 3, 2));

        $endBusinessHour = intval(substr($request->input('end_time'), 0, 2));
        $endBusinessMinute = intval(substr($request->input('end_time'), 3, 2));

        $availbleSeats = 0;
        $dailyAvailbleSeats = 0;

        if ($endBusinessHour >= 0 && $endBusinessHour <= 2) {
            $endBusinessHour += 24;
        }
        $endBusinessHour -= 2;

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $startBusinessMinute = intval(substr($request->input('start_time'), 3, 2));

            for ($hour = $startBusinessHour; $hour <= $endBusinessHour; $hour++) {
                for ($minute = $startBusinessMinute; $minute < 60; $minute += 30) {
                    if ($hour === $endBusinessHour && $minute > $endBusinessMinute) {
                        break;
                    }
                    $desiredStartTime = sprintf('%02d:%02d', $hour, $minute);
                    $desiredEndTime = Carbon::createFromFormat('H:i', $desiredStartTime)->addHour(1)->addMinutes(30)->format('H:i');
                    $desiredDate = Carbon::parse($date)->format('Y-m-d');

                    $alreadyReservedSeats = Reservation::where('visit_date', $desiredDate)
                        ->where('restaurant_id', $restaurantId)
                        ->where(function ($query) use ($desiredStartTime, $desiredEndTime) {
                            $query->WhereBetween('end_time', [$desiredStartTime, $desiredEndTime]);
                        })
                        ->sum('number_of_guests');

                    $availbleSeats = $availbleSeats + $restaurant_seat - $alreadyReservedSeats;
                }
                $startBusinessMinute = 0;
            }
            $dailyAvailbleSeats = $availbleSeats;
            $availbleSeats = 0;
            $dates[$date->format('Y-m-d')] = $dailyAvailbleSeats === 0;
        }

        return response()->json($dates);
    }
}
