<?php

use App\Models\Neighborhood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Complaint;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
//Users-Drivers

Route::post('login', 'App\Http\Controllers\UserController@authenticate');

Route::get('neighborhoods', 'App\Http\Controllers\NeighborhoodController@index');
Route::get('neighborhoods/{neighborhood}', 'App\Http\Controllers\NeighborhoodController@show');
Route::post('complaints', 'App\Http\Controllers\ComplaintController@store');



Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('users', 'App\Http\Controllers\UserController@index');
    Route::get('user', 'App\Http\Controllers\UserController@getAuthenticatedUser');
    Route::get('users/{user}', 'App\Http\Controllers\UserController@show');
    Route::get('users/filter/alternate', 'App\Http\Controllers\UserController@showDriversAlternate');
    Route::get('users/filter/with-truck', 'App\Http\Controllers\UserController@showDriversWithTruck');
    Route::get('users/filter/without-truck', 'App\Http\Controllers\UserController@showDriversWithoutTruck');
    Route::post('register', 'App\Http\Controllers\UserController@register');
    Route::put('users/{user}', 'App\Http\Controllers\UserController@update');
    Route::delete('users/{user}', 'App\Http\Controllers\UserController@delete');

    //Neighborhods


    Route::get('neighborhoods/filter/without-trucks', 'App\Http\Controllers\NeighborhoodController@showNeighborhoodsWithoutTruck');
    Route::get('neighborhoods/filter/without-complaints', 'App\Http\Controllers\NeighborhoodController@showNeighborhoodsWithoutComplaints');
    Route::post('neighborhoods', 'App\Http\Controllers\NeighborhoodController@store');
    Route::put('neighborhoods/{neighborhood}', 'App\Http\Controllers\NeighborhoodController@update');
    Route::delete('neighborhoods/{neighborhood}', 'App\Http\Controllers\NeighborhoodController@delete');

    //Complaints
    Route::get('complaints', 'App\Http\Controllers\ComplaintController@index');
    Route::get('complaints/{complaint}', 'App\Http\Controllers\ComplaintController@show');
    Route::get('drivers/filter/with-complaints', 'App\Http\Controllers\ComplaintController@showDriversWithComplaints');
    Route::get('trucks/filter/with-complaints', 'App\Http\Controllers\ComplaintController@showTrucksWithComplaints');
    Route::get('neighborhoods/filter/with-complaints', 'App\Http\Controllers\ComplaintController@showNeighborhoodsWithComplaints');
    Route::put('complaints/{complaint}', 'App\Http\Controllers\ComplaintController@update');
    Route::delete('complaints/{complaint}', 'App\Http\Controllers\ComplaintController@delete');

    //Trucks
    Route::get('trucks', 'App\Http\Controllers\truckController@index');
    Route::get('trucks/{truck}', 'App\Http\Controllers\truckController@show');
    Route::get('trucks/filter/working', 'App\Http\Controllers\truckController@showTrucksWorking');
    Route::get('trucks/filter/no-working', 'App\Http\Controllers\truckController@showTrucksNoWorking');
    Route::get('trucks/filter/without-drivers', 'App\Http\Controllers\truckController@showTrucksNoDriver');
    Route::get('trucks/filter/with-drivers', 'App\Http\Controllers\truckController@showTrucksDriver');
    Route::get('trucks/{truck}/neighborhoods', 'App\Http\Controllers\TruckController@showTrucksNeighborhood');
    Route::get('trucks/{truck}/complaints', 'App\Http\Controllers\truckController@showTruckComplaints');
    Route::post('trucks', 'App\Http\Controllers\truckController@store');
    Route::put('trucks/{truck}', 'App\Http\Controllers\truckController@update');
    Route::delete('trucks/{truck}', 'App\Http\Controllers\truckController@delete');
});
