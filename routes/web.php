<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clients/import', [ClientController::class, 'showImportForm'])->name('clients.import.form');
Route::post('/clients/import', [ClientController::class, 'importCSV'])->name('clients.import.csv');