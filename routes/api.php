<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([], function () {
    Route::post('auth/login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('auth/signup', [App\Http\Controllers\AuthController::class, 'signup']);
});

Route::group([
    'middleware' => [
        'auth:api',
        'role:User'
    ]
], function () {
    Route::post('loan/apply', [App\Http\Controllers\LoanController::class, 'store']);
    Route::post('loan/list', [App\Http\Controllers\LoanController::class, 'index']);

    Route::post('loan/repayment', [App\Http\Controllers\LoanRepaymentController::class, 'store']);
    Route::post('repayment/list', [App\Http\Controllers\LoanRepaymentController::class, 'index']);
});

Route::group([
    'prefix' => 'admin',
    'middleware' => [
        'auth:api',
        'role:Admin'
    ]
], function () {
    Route::post('loan/change-status', [App\Http\Controllers\LoanController::class, 'changeStatusAdmin']);
    Route::post('loan/list', [App\Http\Controllers\LoanController::class, 'index']);
    Route::post('repayment/list', [App\Http\Controllers\LoanRepaymentController::class, 'index']);
});
