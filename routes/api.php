<?php

use App\Events\admin\DeliveryLocationUpdate;
use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\DeliveryManController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TravelController;
use App\Models\Deliveryman;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com',
    ], 404);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('travels', [TravelController::class, 'index']);
// Route::get('travels/{travel:slug}/tours', [TourController::class, 'index']);
// Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
//     Route::post('travels', [Admin\TravelController::class, 'store']);
//     Route::put('travels/{travel}', [Admin\TravelController::class, 'update']);
//     Route::post('travels/{travel}/tours', [Admin\TourController::class, 'store']);

// });

Route::get('travels', [TravelController::class, 'index']);
Route::get('travels/{travel:slug}/tours', [TourController::class, 'index']);
Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::post('travels', [Admin\TravelController::class, 'store']);
        Route::post('travels/{travel}/tours', [Admin\TourController::class, 'store']);
    });
    Route::put('travels/{travel}', [Admin\TravelController::class, 'update']);
});
// Route::post('deliveries', [DeliveryManController::class,'store']);
Route::post('login', LoginController::class);


Route::get('deliveries/{deliveryman:id}/live-updates', function ($deliveryman) {
    $response = new StreamedResponse(function () use ($deliveryman) {
        while (true) {
            $delivryman = Deliveryman::find($deliveryman);
            $data = json_encode(['message' => $delivryman]);
            echo "data: $data\n\n";
            ob_flush();
            flush();
            sleep(1);
        }
    });
    $response->headers->set('Content-Type', 'text/event-stream');
    $response->headers->set('Cache-Control', 'no-cache');
    $response->headers->set('Connection', 'keep-alive');
    return $response;
});

Route::put('deliveries/{deliveryman}', [DeliveryManController::class, 'update']);
