<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TransactionController::class, 'index']);
Route::post('/upload', [TransactionController::class, 'upload'])->name('upload');
