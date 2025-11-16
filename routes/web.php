<?php

use App\Http\Controllers\DealerController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Default dashboard - redirect based on user role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->canAccessDealerDashboard()) {
        return redirect()->route('dealer.dashboard');
    }

    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Dealer routes (for dealers and admins)
Route::middleware(['auth', 'role:' . User::ROLE_ADMIN . ',' . User::ROLE_DEALER])
    ->prefix('dealer')
    ->name('dealer.')
    ->group(function () {
        Route::get('/dashboard', [DealerController::class, 'dashboard'])->name('dashboard');
        Route::get('/dealers', [DealerController::class, 'index'])->name('index');
    });

// Admin-only dealer switching
Route::middleware(['auth', 'role:' . User::ROLE_ADMIN])
    ->post('/admin/switch-dealer', [DealerController::class, 'switchDealer'])
    ->name('admin.switch-dealer');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
