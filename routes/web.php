<?php

use App\Http\Controllers\AddDeviceController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/addDevice', function () {
    return view('addDevice');
})->name('addDevice');

Route::post('/addDevice', [AddDeviceController::class, 'add']);

Route::get('/devices', function () {
    return view('devices');
})->name('devices');
