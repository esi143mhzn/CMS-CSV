<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

// Import client from CSV
Route::get('/clients/import', [ClientController::class, 'showImportForm'])->name('clients.import.form');
Route::post('/clients/import', [ClientController::class, 'importCSV'])->name('clients.import.csv');

// Duplicate client route
Route::get('clients/duplicate-records', [ClientController::class, 'duplicateClients']);
Route::patch('clients/duplicate-records/{clientId}', [ClientController::class, 'updateDuplicateClient'])->name('update.duplicate-clients');
Route::delete('clients/duplicate-records/{clientId}', [ClientController::class, 'deleteDuplicateClient'])->name('delete.duplicate-clients');