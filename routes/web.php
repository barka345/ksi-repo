<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->get('/dashboard', function () {
        return redirect(auth()->user()->homeRoute());
    })->name('dashboard');

Route::middleware(['auth', 'role:user'])->prefix('my')->name('user.')->group(function () {
    Route::get('/dashboard', fn () => 'Dashboard Pelanggan')->name('dashboard');
});

Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => 'Dashboard Admin')->name('dashboard');
});

Route::middleware(['auth', 'role:super_admin'])->prefix('super')->name('super.')->group(function () {
    Route::get('/dashboard', fn () => 'Dashboard Super Admin')->name('dashboard');
});