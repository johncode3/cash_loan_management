<?php

use App\Http\Controllers\auth\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;

//Login Page
Route::get("/", function () {
    return view('/auth/login');
})->name("Login");

//Dashboard Page
Route::get("dashboard", function () {
    return view('dashboard');
})->name("Dashboard");

// Route Fallback for 404 Not Found
Route::fallback(function () {
    return response()->view("errors.404", [], 404);
})->name("404");

//Category Page
Route::resource('categories', CategoryController::class);

//Employee Page
Route::resource('employees', EmployeeController::class);

//Customer Page
Route::resource('customers', CustomerController::class);

//Authentication Routes
Route::controller(AccountController::class)->group(function () {
    Route::prefix('accounts')->group(function (){
        Route::get('login', 'login')->name('login');
        Route::post('login', 'authenticate')->name('authenticate');
        Route::get('register', 'register')->name('register');
        Route::post('register', 'create')->name('create');
        Route::post('logout', 'logout')->name('logout');
    });
});