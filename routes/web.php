<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return redirect()->route('transactions.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/contacts', [ContactController::class, 'index'])
    ->name('contacts.index');


// Protected: tik prisijungę vartotojai gali pasiekti finansus ir kontaktus
Route::middleware('auth')->group(function () {
    Route::resource('contacts', ContactController::class)
        ->only(['create', 'store']);
        
    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
});

Route::resource('students', StudentController::class);