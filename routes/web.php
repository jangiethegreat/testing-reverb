<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncmentController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/announcements', [AnnouncmentController::class, 'index'])->name('announcements.index');
Route::post('/announcements', [AnnouncmentController::class, 'store'])->name('announcements.store');