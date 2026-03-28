<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\TentativeController;
use App\Http\Controllers\BankQrController;
use App\Http\Controllers\RsvpController;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);
    //wedding route
    Route::post('wedding/store', [WeddingController::class, 'store']);
    Route::get('wedding/show', [WeddingController::class, 'show']);
    Route::post('wedding/update', [WeddingController::class, 'update']);
    Route::post('wedding/publish', [WeddingController::class, 'publish']);
    //tentative route
    Route::get('tentative/index', [TentativeController::class, 'index']);
    Route::post('tentative/store', [TentativeController::class, 'store']);
    Route::post('tentative/destroy/{id}', [TentativeController::class, 'destroy']);
    Route::post('tentative/publish', [TentativeController::class, 'publish']);
    //bank qr route
    Route::get('bankqr/show', [BankQrController::class, 'show']);
    Route::post('bankqr/update', [BankQrController::class, 'update']);
    Route::post('bankqr/store', [BankQrController::class, 'store']);
    Route::post('bankqr/publish', [BankQrController::class, 'publish']);

    //rsvp visitor
    Route::post('visitor/rsvp/{wedding_code}', [RsvpController::class, 'store']);

    //photo route 
    Route::post('photo/store/{wedding_code}', [PhotoController::class, 'store']);
    Route::get('photo/index/{wedding_code}', [PhotoController::class, 'index']);
});
