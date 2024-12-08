<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\RoomCategoryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SubDistrictController;
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

        Route::prefix('hotel')->group(function () {
            Route::get('index', [HotelController::class, 'index']);
            Route::post('create', [HotelController::class, 'create']);
            Route::get('edit/{hotel}', [HotelController::class, 'edit']);
            Route::post('update/{hotel}', [HotelController::class, 'update']);
        });
        Route::prefix('category')->group(function () {
            Route::get('index', [RoomCategoryController::class, 'index']);
            Route::post('create', [RoomCategoryController::class, 'create']);
            Route::get('edit/{roomCategory}', [RoomCategoryController::class, 'edit']);
            Route::post('update/{roomCategory}', [RoomCategoryController::class, 'update']);
        });
        Route::prefix('room')->group(function () {
            Route::get('index', [RoomController::class, 'index']);
            Route::post('create', [RoomController::class, 'create']);
            Route::get('edit/{roomCategory}', [RoomController::class, 'edit']);
            Route::post('update/{roomCategory}', [RoomController::class, 'update']);
        });
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


/*******************************
Common API
******************************* */
Route::prefix('common')->middleware('throttle:1000,1')->group(function () {
    Route::get('get-division', [DivisionController::class, 'apiGetDivision']);
    Route::get('get-district', [DistrictController::class, 'apiGetDistrict']);
    Route::get('get-sub-district', [SubDistrictController::class, 'apiGetSubDistrict']);



    Route::get('get-hotels', [HotelController::class, 'apiGetHotels']);


});
