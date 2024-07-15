<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/map', function () {
    return view('map');
});
Route::get('/liveMap', function () {
    return view('liveLocation');
});

Route::get('/orders/{deliveryman}', [\App\Http\Controllers\OrderController::class, 'show'])
->name('orders.show');

