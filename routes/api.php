<?php

use App\Http\Controllers\API\Order\OrderController;
use App\Http\Controllers\API\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProjectController;
use App\Models\Project;
use App\Http\Controllers\LeadController; */

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//restituisce tutti i ristoranti
Route::get('/restaurants', [RestaurantController::class, 'index']);


//restituisce il menù del singolo ristorante
Route::get('/restaurant/{id}', [RestaurantController::class, 'getSingleRestaurant']);


//restituisce la query con tutte le tipologie di ristorante filtrati
Route::get('/types', [RestaurantController::class, 'filteredType']);

//questo genera il primo token per il servizio di braintree
Route::get('orders/generate',[OrderController::class, 'generate']);

//questo permette di completare il pagamento grazie al token recuperato precedentemente
Route::post('orders/make/payment',[OrderController::class, 'makePayment']);