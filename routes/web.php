<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpellNumberController;

Route::get('/', [SpellNumberController::class, 'index'])->name('spell.index');
Route::post('/convert', [SpellNumberController::class, 'convert'])->name('convert.number');
Route::get('/live-preview', [SpellNumberController::class, 'livePreview'])->name('live.preview');
Route::post('/toggle-favorite/{id}', [SpellNumberController::class, 'toggleFavorite'])->name('toggle.favorite');
Route::post('/bulk-delete', [SpellNumberController::class, 'bulkDelete'])->name('bulk.delete');
Route::delete('/clear-all', [SpellNumberController::class, 'clearAll'])->name('clear.all');
Route::get('/export-csv', [SpellNumberController::class, 'exportCsv'])->name('export.csv');
Route::delete('/delete/{id}', [SpellNumberController::class, 'destroy'])->name('delete.number');