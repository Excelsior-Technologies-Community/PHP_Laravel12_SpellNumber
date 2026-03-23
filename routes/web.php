<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpellNumberController;

Route::get('/', [SpellNumberController::class, 'index']);
Route::post('/convert', [SpellNumberController::class, 'convert'])->name('convert.number');

