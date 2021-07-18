<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
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
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->prefix('users')->group(function () {
    Route::middleware(['admin'])->group( function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/me', [UserController::class, 'getCurrentUser']);
        Route::post('/store', [UserController::class, 'store']);
        Route::delete('/destroy', [UserController::class, 'destroy']);
    });
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::middleware(['auth:api'])->prefix('expense_category')->group(function () {
    Route::middleware(['admin'])->group( function () {
        Route::get('/', [ExpenseCategoryController::class, 'index']);
        Route::post('/store', [ExpenseCategoryController::class, 'store']);
        Route::delete('/destroy', [ExpenseCategoryController::class, 'destroy']);
    });
    Route::get('/chartdata', [ExpenseCategoryController::class, 'getExpenseCategoryChartdata']);
});

Route::middleware(['auth:api'])->prefix('expense')->group(function () {
    Route::get('/', [ExpenseController::class, 'index']);
    Route::get('/all', [ExpenseController::class, 'all']);
    Route::post('/store', [ExpenseController::class, 'store']);
    Route::delete('/destroy', [ExpenseController::class, 'destroy']);
});

Route::middleware(['auth:api'])->prefix('roles')->group(function () {
    Route::middleware(['admin'])->group( function () {
        Route::get('/', [RolesController::class, 'index']);
        Route::post('/store', [RolesController::class, 'store']);
        Route::delete('/destroy', [RolesController::class, 'destroy']);
    });
});