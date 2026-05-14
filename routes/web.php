<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpellNumberController;

Route::get('/', [SpellNumberController::class, 'index']);

Route::post('/convert', [SpellNumberController::class, 'convert'])->name('convert.number');

Route::delete('/delete/{id}', [SpellNumberController::class, 'destroy'])->name('delete.number');

Route::delete('/clear-all', [SpellNumberController::class, 'clearAll']);