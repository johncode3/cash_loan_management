<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:customer,admin'])->group(function () {
        Route::get('/loans/apply', [LoanController::class, 'create'])->name('loans.apply');
        Route::post('/loans/apply', [LoanController::class, 'store'])->name('loans.store');
    });

    Route::middleware(['role:loan_officer,admin'])->group(function () {
        Route::get('/loans/pending', [LoanController::class, 'pending'])->name('loans.pending');
        Route::post('/loans/{id}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    });

    Route::middleware(['role:cashier,admin'])->group(function () {
        Route::get('/repayments/create', [RepaymentController::class, 'create'])->name('repayments.create');
        Route::post('/loans/{id}/repay', [RepaymentController::class, 'store'])->name('repayments.store');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::post('/loans/{id}/disburse', [LoanController::class, 'disburse'])->name('loans.disburse');
        Route::get('/dashboard/overdue', [DashboardController::class, 'overdue'])->name('dashboard.overdue');
        Route::resource('employees', EmployeeController::class);
    });

    Route::middleware(['role:admin,loan_officer,cashier'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('customers', CustomerController::class);
    });

    Route::get('/loans/{id}', [LoanController::class, 'show'])->name('loans.show');
    Route::get('/loans/{id}/schedule', [LoanController::class, 'schedule'])->name('loans.schedule');
});

require __DIR__.'/auth.php';