<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogReaderController;


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

});
Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::post('read-log', [LogReaderController::class, 'read'])->name('read');
