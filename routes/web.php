<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('cliente', [ClienteController::class, 'index'])->name('cliente.index');
Route::post('cliente/search', [ClienteController::class, 'search'])->name('cliente.search');
Route::get('cliente/create', [ClienteController::class, 'create'])->name('cliente.create');
Route::post('cliente', [ClienteController::class, 'store'])->name('cliente.store');
Route::get('cliente/{id}/edit', [ClienteController::class, 'edit'])->name('cliente.edit');
Route::put('cliente/{id}', [ClienteController::class, 'update'])->name('cliente.update');
Route::delete('cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
