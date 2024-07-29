<?php

use App\Http\Controllers\CompanyFinancialsController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CompanyFinancialsController::class, 'index'])->name('index');
Route::post('financials/import', [CompanyFinancialsController::class, 'import'])->name('financials.import');
Route::get('financials/{id}/edit', [CompanyFinancialsController::class, 'edit'])->name('financials.edit');
Route::put('financials/update/{id}', [CompanyFinancialsController::class, 'update'])->name('financials.update');
Route::delete('financials/{id}', [CompanyFinancialsController::class, 'delete'])->name('financials.delete');

Route::get('sendEmail/{id}', [MailController::class, 'sendEmail'])->name('sendEmail'); ;