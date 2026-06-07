<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;

// Pradinis puslapis iškart nukreipia į finansus
Route::get('/', function () {
    return redirect()->route('transactions.index');
});

// Jetstream standartinė grupė
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Viešas kontaktų puslapis
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');

// Apsaugoti maršrutai (tik prisijungusiems vartotojams)
Route::middleware('auth')->group(function () {
    Route::resource('contacts', ContactController::class)->only(['create', 'store']);
    
    // FINANSŲ ATASKAITA (Būtinai virš resource)
    Route::get('transactions/report', [TransactionController::class, 'report'])->name('transactions.report');

    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
});

// Studentų resursas (paliktas serveryje)
Route::resource('students', StudentController::class);