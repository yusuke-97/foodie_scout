<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WebController;
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

Route::get('/',  [WebController::class, 'index']);

Route::post('/restaurants/{restaurant}/favorite', [RestaurantController::class, 'addFavorite'])->name('restaurants.favorite');
Route::delete('/restaurants/{restaurant}/favorite', [RestaurantController::class, 'removeFavorite'])->name('restaurants.unfavorite');
Route::resource('restaurants', RestaurantController::class);

Route::get('restaurants/{restaurant}/reservations', [ReservationController::class, 'restaurantReservation'])->name('restaurant.reservations');
Route::resource('reservations', ReservationController::class);
Route::get('/available-seats', [ReservationController::class, 'availableSeatsForDay']);
Route::get('/available-days', [ReservationController::class, 'availableDaysForMonth']);

Route::controller(UserController::class)->group(function () {
    Route::get('users/mypage', 'mypage')->name('mypage');
    Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
    Route::put('users/mypage', 'update')->name('mypage.update');
    Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
    Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
    Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
    Route::get('users/mypage/reservation_history', 'reservation_history_index')->name('mypage.reservation_history');
    Route::get('users/mypage/reservation_history/{reservation}', 'reservation_history_show')->name('mypage.reservation_history_show');
    Route::get('users/mypage/charge', 'charge_page')->name('charge.page');
    Route::post('users/mypage/charge/point', 'charge_point')->name('charge.point');

    Route::get('users/mypage/profile', 'profile')->name('mypage.profile');
    Route::post('/follow/{user}', 'follow')->name('follow');
    Route::delete('/unfollow/{user}', 'unfollow')->name('unfollow');
    Route::get('users/mypage/following', 'following')->name('mypage.following');
    Route::get('users/mypage/following/{following}', 'follower_show')->name('following.show');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
