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
Route::get('/documentos/receituario_especial/{id}', [App\Http\Controllers\DocumentosController::class, 'receituarioEspecial'])->name('documentos.receituarioEspecial');
Route::get('/documentos/receituarioNew/{id}/print', [App\Http\Controllers\DocumentosController::class, 'printReceituario'])->name('documentos.receituarionew.print');
Route::get('/documentos/receituarioNewEspecial/{id}/print', [App\Http\Controllers\DocumentosController::class, 'printReceituarioEspecial'])->name('documentos.receituarionewEspecial.print');
Route::get('/documentos/solicitacaoExames/{id}/print', [App\Http\Controllers\DocumentosController::class, 'printSolicitacaoExames'])->name('documentos.solicitacaoExames.print');
Route::get('/documentos/encaminhamentos/{id}/print', [App\Http\Controllers\DocumentosController::class, 'printEncaminhamentos'])->name('documentos.encaminhamentos.print');
