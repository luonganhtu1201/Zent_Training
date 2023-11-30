<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::group(['middleware' => ['api']], function () {
    Route::prefix('/')->group(function () {
        Route::group(["prefix" => "auth"], function () {
            Route::post("/login", [Controllers\AuthController::class, "login"]);
        });
    });
    Route::group(["middleware" => ["jwt.auth", "user.active"]], function () {
        Route::group(["prefix" => "users"], function () {
            Route::get("/", [Controllers\UserController::class, "index"]);
            Route::post("/", [Controllers\UserController::class, "store"]);
            Route::post("/{id}", [Controllers\UserController::class, "update"]);
            Route::delete("/{id}", [Controllers\UserController::class, "destroy"]);
        });
    });
});
