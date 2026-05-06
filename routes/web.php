<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CampaignController::class, 'index'])->name('home');

Route::resource('campaigns', CampaignController::class);

Route::get('/debug-mail', function() {
    return [
        'default' => config('mail.default'),
        'mailers' => array_keys(config('mail.mailers')),
        'brevo_config' => config('mail.mailers.brevo-api'),
        'env_mailer' => env('MAIL_MAILER')
    ];
});

Route::get('/force-seed', function() {
    // 1. Run migrations to ensure all columns (like delete_requested) exist
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);

    // 2. Force update admin user
    \App\Models\User::updateOrCreate(
        ['role' => 'admin'],
        [
            'name' => 'Admin User',
            'email' => 'admincrowdfund@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email_verified_at' => now(),
        ]
    );

    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return "SUCCESS: Database Migrated & Admin email set to admincrowdfund@gmail.com with password: password.";
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/donate', [DonationController::class, 'store'])->name('donations.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware('can:admin-access')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/admin/campaigns/{campaign}/status', [AdminController::class, 'updateCampaignStatus'])->name('admin.campaigns.status');
        Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });
});

require __DIR__.'/auth.php';
