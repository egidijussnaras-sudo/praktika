<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
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


// Protected: tik prisijungę gali kurti / siųsti formą
Route::middleware('auth')->group(function () {
    Route::resource('contacts', ContactController::class)
        ->only(['create', 'store']);
});

