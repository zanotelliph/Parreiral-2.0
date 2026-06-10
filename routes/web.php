<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ReservaEventoController;
use App\Http\Controllers\CompraProdutoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\EventoController;
//use App\Http\Controllers\DashboardController;
use App\Charts\ProdutoMaisComprado;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('cliente', [ClienteController::class, 'index'])->name('cliente.index');
Route::post('cliente/search', [ClienteController::class, 'search'])->name('cliente.search');
Route::get('cliente/create', [ClienteController::class, 'create'])->name('cliente.create');
Route::post('cliente', [ClienteController::class, 'store'])->name('cliente.store');
Route::get('cliente/{id}/edit', [ClienteController::class, 'edit'])->name('cliente.edit');
Route::put('cliente/{id}', [ClienteController::class, 'update'])->name('cliente.update');
Route::delete('cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');

Route::resource('produto', ProdutoController::class);
Route::resource('reservas-eventos', ReservaEventoController::class);
Route::resource('eventos', EventoController::class);
Route::resource('compras-produtos', CompraProdutoController::class);
Route::resource('estoques', EstoqueController::class);
// Route::get('/dashboard', [DashboardController::class, 'index']);
// Route::get('/', function (ProdutoMaisComprado $chart) {
//     return view('dashboard', [
//         'chart' => $chart->build()
//     ]);
// });
Route::get(
    'compras-produtos/chart',
    [CompraProdutoController::class, 'chart']
)->name('compras-produtos.chart');