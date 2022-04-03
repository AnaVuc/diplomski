<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/login', function () {
//     return view('welcome');
// });
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('auth/login');
})->name('login');


Route::get('/register', function () {
    return view('auth/register');
})->name('register');

Route::get('/{any}', function () {
    return view('home');
})->where('any','.*');

