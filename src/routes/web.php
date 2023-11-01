<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ElasticsearchController;

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

Route::get('/search', [ElasticsearchController::class, 'search'])->name('search');

Route::get('/',  [WebController::class, 'index']);

Route::get('/reviews/create/{reservation}', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/ranking', [ReviewController::class, 'restaurantRanking'])->name('reviews.ranking');
Route::get('/reviews/edit_ranking/{category}', [ReviewController::class, 'restaurantEditRanking'])->name('reviews.edit_ranking');
Route::post('/reviews/update', [ReviewController::class, 'update'])->name('reviews.update');

Route::post('/restaurants/{restaurant}/favorite', [RestaurantController::class, 'addFavorite'])->name('restaurants.favorite');
Route::delete('/restaurants/{restaurant}/favorite', [RestaurantController::class, 'removeFavorite'])->name('restaurants.unfavorite');
Route::get('/restaurants/search', [RestaurantController::class, 'search'])->name('restaurants.search');
Route::resource('restaurants', RestaurantController::class);

Route::resource('reservations', ReservationController::class);
Route::post('/reservation/prepare', [ReservationController::class, 'prepareConfirmation']);
Route::get('/reservation/{restaurant_id}/confirm', [ReservationController::class, 'confirmReservation'])->name('reservation.confirm');
Route::get('/available-seats', [ReservationController::class, 'availableSeatsForDay']);
Route::get('/available-days', [ReservationController::class, 'availableDaysForMonth']);

Route::controller(UserController::class)->group(function () {
    Route::get('users/mypage', 'mypage')->name('mypage');
    Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
    Route::post('users/mypage/update', 'update')->name('mypage.update');
    Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
    Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
    Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
    Route::get('users/mypage/reservation_history', 'reservation_history_index')->name('mypage.reservation_history');
    Route::get('users/mypage/reservation_history/{reservation}', 'reservation_history_show')->name('mypage.reservation_history_show');
    Route::get('users/mypage/charge', 'charge_page')->name('charge.page');
    Route::post('users/mypage/charge/point', 'charge_point')->name('charge.point');
    Route::get('users/{user}/mypage/profile', 'profile')->name('mypage.profile');
    Route::post('/follow/{user}', 'follow')->name('follow');
    Route::delete('/unfollow/{user}', 'unfollow')->name('unfollow');
    Route::get('users/mypage/following', 'following')->name('mypage.following');
    Route::get('users/mypage/following/{following}', 'follower_show')->name('following.show');
    Route::get('users/mypage/register_card', 'register_card')->name('mypage.register_card');
    Route::post('users/mypage/token', 'token')->name('mypage.token');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
