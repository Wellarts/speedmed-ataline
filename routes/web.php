<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () { return redirect('/admin'); })->name('login');


Route::get('/documentos/prontuario/{id}', [App\Http\Controllers\DocumentosController::class, 'prontuario'])->name('documentos.prontuario');
Route::get('/documentos/receituario/{id}', [App\Http\Controllers\DocumentosController::class, 'receituarioComum'])->name('documentos.receituarioComum');
