<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
//importing controller class
use App\Http\Controllers\t2;
use App\Http\Controllers\t3;

Route::get('/', function () {
    return view('welcome');
});
//route view without calling any controller
Route::get('/t1', function () {
    return view('Route without calling Controller');
});
//conecting route to controller to view
Route::get('/t2/{id}',[t2::class,'viewT2']);

//conecting route to controller to view  with Null protection
Route::get('/t3/{id?}/{name?}', [t3::class, 'handle']);

//login page
Route::get('/login', function () {
    return view('login');
});