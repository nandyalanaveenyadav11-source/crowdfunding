<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\DonationController;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/campaigns', [CampaignController::class, 'index']);
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/campaign', [CampaignController::class, 'store']);
    Route::post('/donate', [DonationController::class, 'store']);
    
    Route::get('/user/dashboard', function (Request $request) {
        return [
            'user' => $request->user(),
            'campaigns' => Campaign::where('user_id', $request->user()->id)->get(),
            'donations' => $request->user()->donations()->with('campaign')->get(),
        ];
    });
});
