<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\EarningController as ClientEarningController;
use App\Http\Controllers\Client\ExpensesController as ClientExpensesController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController as AuthAdmin;
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
    Route::post('/admin/user/store', [AuthAdmin::class, 'storeByAdmin'])->name('admin.users.store');
    Route::post('/admin/profile/destroy/{id}', [AuthAdmin::class, 'deleteByAdmin'])->name('admin.profile.destroy');
    Route::put('/admin/users/{id}', [AuthAdmin::class, 'updateByAdmin'])->name('admin.users.update');
});
Route::middleware('authClient')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/month/{month}', [ClientDashboardController::class, 'month'])->name('dashboard.month');
    Route::get('/earning', [ClientEarningController::class, 'index'])->name('earning');
    Route::get('/expenses', [ClientExpensesController::class, 'index'])->name('expenses');
    Route::resource('depositories', DepositoryController::class);
    Route::resource('histories', HistoryController::class);
    Route::put('/users/photo/{id}', [AuthAdmin::class, 'updatephoto'])->name('users.update.photo');
});

require __DIR__.'/auth.php';