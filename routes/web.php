<?php

use App\Http\Controllers\CadastroController;
use App\Http\Controllers\ControleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Clientes (CRUD completo)
Route::resource('cadastros', CadastroController::class);

// Movimentações (CRUD completo)
Route::resource('controles', ControleController::class);

// Produtos (placeholder — implemente conforme necessário)
Route::get('/produtos', fn() => redirect()->route('dashboard'))->name('produtos.index');

// Relatórios
Route::prefix('relatorios')->name('relatorios.')->group(function () {
    Route::get('/',         [RelatorioController::class, 'index'])->name('index');
    Route::get('/exportar', [RelatorioController::class, 'exportar'])->name('exportar');
});
