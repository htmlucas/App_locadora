<?php

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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/marcas', function() {return view('app.marcas');})->name('marcas')->middleware('auth');
Route::get('/modelos', function() {return view('app.modelos');})->name('modelos')->middleware('auth');
Route::get('/carro', function() {return view('app.carro');})->name('carro')->middleware('auth');
Route::get('/cliente', function() {return view('app.cliente');})->name('cliente')->middleware('auth');
Route::get('/locacao', function() {return view('app.locacao');})->name('locacao')->middleware('auth');
