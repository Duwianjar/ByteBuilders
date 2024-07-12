<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\EarningController as ClientEarningController;
use App\Http\Controllers\Client\ExpensesController as ClientExpensesController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\HistoryController;
use App\Http\Controllers\Client\DepositoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('authAdmin')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
});
Route::middleware('authClient')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/month/{month}', [ClientDashboardController::class, 'month'])->name('dashboard.month');
    Route::get('/earning', [ClientEarningController::class, 'index'])->name('earning');
    Route::get('/expenses', [ClientExpensesController::class, 'index'])->name('expenses');
    Route::resource('depositories', DepositoryController::class);
    Route::resource('histories', HistoryController::class);
});

require __DIR__.'/auth.php';