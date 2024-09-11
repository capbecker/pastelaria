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
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;

Route::get('/', function () {   
    return view('home');
});

Route::get('/cliente', [ClienteController::class, 'index']);

Route::get('/cliente/create', [ClienteController::class, 'create']);
Route::post('/cliente', [ClienteController::class, 'store'])->name('cliente.store');

Route::get('/cliente/{id}', [ClienteController::class, 'edit'])->name('cliente.edit');
Route::put('/cliente/{id}', [ClienteController::class, 'update'])->name('cliente.update');

Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');





Route::get('/produto', [ProdutoController::class, 'index']);

Route::get('/produto/create', [ProdutoController::class, 'create']);
Route::post('/produto', [ProdutoController::class, 'store'])->name('produto.store');

Route::get('/produto/{id}', [ProdutoController::class, 'edit'])->name('produto.edit');
Route::put('/produto/{id}', [ProdutoController::class, 'update'])->name('produto.update');

Route::delete('/produto/{id}', [ProdutoController::class, 'destroy'])->name('produto.destroy');



Route::get('/pedido', [PedidoController::class, 'index']);

Route::get('/pedido/create', [PedidoController::class, 'create']);
Route::post('/pedido', [PedidoController::class, 'store'])->name('pedido.store');

Route::get('/pedido/{id}', [PedidoController::class, 'edit'])->name('pedido.edit');
Route::put('/pedido/{id}', [PedidoController::class, 'update'])->name('pedido.update');

Route::delete('/pedido/{id}', [PedidoController::class, 'destroy'])->name('pedido.destroy');


