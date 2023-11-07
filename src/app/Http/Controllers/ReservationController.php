<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function prepareConfirmation(Request $request)
    {
        $reservation_data = $request->all();
        session(['reservation_data' => $reservation_data]);

        return response()->json(['redirect_to' => route('reservation.confirm', ['restaurant_id' => $reservation_data['restaurant_id']])]);
    }


    public function confirmReservation($restaurant_id)
    {
        $reservation_data = session('reservation_data', []);

        if (empty($reservation_data)) {
            return redirect()->back()->with('error', '予約データが見つかりませんでした。再度お試しください。');
        }

        return view('reservations.confirm', compact('reservation_data'));
    }

    public function editReservation(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $reservation_id = $request->input('reservation_id');

        $existing_reservation_ids = Reservation::where('user_id', $user->id)
            ->pluck('id')
            ->toArray();
        
        if (in_array($reservation_id, $existing_reservation_ids)) {
            $existing_reservation = Reservation::where('user_id', $user->id)
                ->where('id', $reservation_id)
                ->first();
            if ($existing_reservation) {
                $existing_reservation->number_of_guests = $request->input('number_of_guests');
                $existing_reservation->reservation_fee += $request->input('reservation_fee');
                
                $raw_date = $request->input('visit_date');
                $correct_format_date = explode('T', $raw_date)[0];
                $existing_reservation->visit_date = $correct_format_date;

                $visit_time = $request->input('visit_time');
                $existing_reservation->visit_time = $visit_time;

                $end_time = Carbon::createFromFormat('H:i', $visit_time)->addHour(1)->addMinutes(30)->format('H:i');
                $existing_reservation->end_time = $end_time;

                $user->point = $user->point - $request->input('reservation_fee');
                $user->save();

                $existing_reservation->save();
            }
        } else {
            $reservation = new Reservation();
            $raw_date = $request->input('visit_date');
            $correct_format_date = explode('T', $raw_date)[0];
            $reservation->visit_date = $correct_format_date;

            $visit_time = $request->input('visit_time');
            $reservation->visit_time = $visit_time;

            $end_time = Carbon::createFromFormat('H:i', $visit_time)->addHour(1)->addMinutes(30)->format('H:i');
            $reservation->end_time = $end_time;

            $reservation->number_of_guests = $request->input('number_of_guests');
            $reservation->reservation_fee = $request->input('reservation_fee');

            $user->point = $user->point - $reservation->reservation_fee;
            $user->save();

            $reservation->user_id = $user->id;
            $reservation->restaurant_id = $request->input('restaurant_id');

            $reservation->save();
        }

        return response()->json([
            'message' => 'Reservation successful',
            'redirect_to' => route('mypage.reservation_history')
        ]);
    }


    public function availableSeatsForDay(Request $request)
    {
        $desired_date = $request->input('visit_date');

        $start_business_hour = intval(substr($request->input('start_time'), 0, 2));
        $start_business_minute = intval(substr($request->input('start_time'), 3, 2));

        $end_business_hour = intval(substr($request->input('end_time'), 0, 2));

        $reservation_visit_date = $request->input('reservation_date');
        $reservation_visit_time = $request->input('reservation_time');
        $reservation_guests = $request->input('reservation_guests');

        if ($reservation_visit_time) {
            $reservation_end_time = Carbon::createFromFormat('H:i', $reservation_visit_time)->addMinutes(90)->format('H:i');
        }

        if ($end_business_hour === 0) {
            $end_business_hour += 24;
        }
        
        $results = [];

        for ($hour = $start_business_hour; $hour < $end_business_hour; $hour++) {
            for ($minute = $start_business_minute; $minute < 60; $minute += 30) {
                $desired_start_time = sprintf('%02d:%02d', $hour, $minute);
                $desired_end_time = Carbon::createFromFormat('H:i', $desired_start_time)->addHour(1)->addMinutes(30)->format('H:i');
                
                $already_reserved_seats = Reservation::where('visit_date', $desired_date)
                    ->where('restaurant_id', $request->input('restaurant_id'))
                    ->where(function ($query) use ($desired_start_time, $desired_end_time) {
                        $query->WhereBetween('end_time', [$desired_start_time, $desired_end_time]);
                    })
                    ->sum('number_of_guests');

                if (
                    ($desired_date === $reservation_visit_date) &&
                    ($desired_start_time >= $reservation_visit_time) &&
                    ($desired_start_time <= $reservation_end_time)
                ) {
                    $already_reserved_seats -= $reservation_guests;
                }

                $results[$desired_start_time] = $already_reserved_seats + $request->input('number_of_guests');
            }

            $start_business_minute = 0;
        }

        return response()->json(['reserved_seats' => $results]);
    }


    public function availableDaysForMonth(Request $request)
    {
        $restaurant_id = $request->input('restaurant_id');
        $restaurant_seat = $request->input('restaurant_seat');
        $start_date = Carbon::parse($request->input('start_date'));
        $end_date = Carbon::parse($request->input('end_date'));

        $dates = [];

        $start_business_hour = intval(substr($request->input('start_time'), 0, 2));
        $start_business_minute = intval(substr($request->input('start_time'), 3, 2));

        $end_business_hour = intval(substr($request->input('end_time'), 0, 2));
        $end_business_minute = intval(substr($request->input('end_time'), 3, 2));

        $available_seats = 0;
        $daily_availble_seats = 0;

        if ($end_business_hour >= 0 && $end_business_hour <= 2) {
            $end_business_hour += 24;
        }
        $end_business_hour -= 2;

        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $start_business_minute = intval(substr($request->input('start_time'), 3, 2));

            for ($hour = $start_business_hour; $hour <= $end_business_hour; $hour++) {
                for ($minute = $start_business_minute; $minute < 60; $minute += 30) {
                    if ($hour === $end_business_hour && $minute > $end_business_minute) {
                        break;
                    }
                    $desired_start_time = sprintf('%02d:%02d', $hour, $minute);
                    $desired_end_time = Carbon::createFromFormat('H:i', $desired_start_time)->addHour(1)->addMinutes(30)->format('H:i');
                    $desired_date = Carbon::parse($date)->format('Y-m-d');

                    $already_reserved_seats = Reservation::where('visit_date', $desired_date)
                        ->where('restaurant_id', $restaurant_id)
                        ->where(function ($query) use ($desired_start_time, $desired_end_time) {
                            $query->WhereBetween('end_time', [$desired_start_time, $desired_end_time]);
                        })
                        ->sum('number_of_guests');

                    $available_seats = $available_seats + $restaurant_seat - $already_reserved_seats;
                }
                $start_business_minute = 0;
            }
            $daily_availble_seats = $available_seats;
            $available_seats = 0;
            $dates[$date->format('Y-m-d')] = $daily_availble_seats === 0;
        }

        return response()->json($dates);
    }
}
