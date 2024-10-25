<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('leads')->group(function () {
    Route::get('/', [LeadController::class, 'index']);
    Route::post('/', [LeadController::class, 'store']);
    Route::put('/{lead}/status', [LeadController::class, 'updateStatus']);
    Route::put('/{lead}/assign', [LeadController::class, 'updateAssignee']);


    Route::prefix('/{lead}/surveys')->group(function () {
        Route::get('/', [SurveyController::class, 'index']);
        Route::post('/', [SurveyController::class, 'store']);
        Route::put('/{survey}/status', [SurveyController::class, 'updateStatus']);
    });

    Route::prefix('/{lead}/proposals')->group(function () {
        Route::get('/', [ProposalController::class, 'index']);
        Route::post('/', [ProposalController::class, 'store']);
        Route::put('/{proposal}/status', [ProposalController::class, 'updateStatus']);
    });
});
