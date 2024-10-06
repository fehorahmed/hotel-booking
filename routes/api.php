<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/user-info', function (Request $request) {
    dd($request->user());
    return $request->user();
});

/*******************************
Admin API
******************************* */

Route::post('admin/login', [AdminController::class, 'apiLogin']);

Route::middleware('auth:sanctum', 'ability:admin', 'throttle:1000,1')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('profile', [AdminController::class, 'profile']);
    });
});




/*******************************
Manager API
******************************* */
Route::post('manager/login', [ManagerController::class, 'apiLogin']);

Route::middleware('auth:sanctum', 'ability:manager', 'throttle:1000,1')->group(function () {
    Route::prefix('manager')->group(function () {
        Route::get('profile', [AdminController::class, 'profile']);
    });
});


/*******************************
User API
******************************* */
Route::post('user/login', [UserController::class, 'apiLogin']);
Route::post('user/registration', [UserController::class, 'apiRegistration']);

Route::middleware('auth:sanctum', 'ability:user', 'throttle:1000,1')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('profile', [AdminController::class, 'profile']);
    });
});
