<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoIconController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/icon', function () {
    return view('index');
});

// Logo Icon routes
Route::get('/logo', [LogoIconController::class, 'index'])->name('logo.index');
Route::post('/logo/store', [LogoIconController::class, 'store'])->name('logo.store');
Route::post('/logo/update/{id}', [LogoIconController::class, 'update'])->name('logo.update');
Route::delete('/logo/delete/{id}', [LogoIconController::class, 'destroy'])->name('logo.delete');
Route::get('/logo/get/{id}', [LogoIconController::class, 'getIcon'])->name('logo.get');