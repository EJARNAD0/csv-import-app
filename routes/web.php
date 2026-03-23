<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/upload', [TransactionController::class, 'upload'])->name('upload');
