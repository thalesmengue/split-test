<?php

use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/produtos')->group(function () {
    Route::get('/', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::post('/', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/{produto}', [ProdutoController::class, 'find'])->name('produtos.find');
    Route::put('/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/{produto}', [ProdutoController::class, 'delete'])->name('produtos.delete');
});
