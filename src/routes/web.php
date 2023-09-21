<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/restaurants/{restaurant}/favorite', [RestaurantController::class, 'addFavorite'])->name('restaurants.favorite');
Route::delete('/restaurants/{restaurant}/favorite', [RestaurantController::class, 'removeFavorite'])->name('restaurants.unfavorite');
Route::resource('restaurants', RestaurantController::class);

Route::get('restaurants/{restaurant}/reservations', [ReservationController::class, 'restaurantReservation'])->name('restaurant.reservations');
Route::resource('reservations', ReservationController::class);

Route::controller(UserController::class)->group(function () {
    Route::get('users/mypage', 'mypage')->name('mypage');
    Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
    Route::put('users/mypage', 'update')->name('mypage.update');
    Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
    Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
    Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
    Route::get('users/mypage/reservation_history', 'reservation_history_index')->name('mypage.reservation_history');
    Route::get('users/mypage/reservation_history/{reservation}', 'reservation_history_show')->name('mypage.reservation_history_show');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
