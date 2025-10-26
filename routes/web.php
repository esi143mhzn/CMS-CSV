<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return redirect('/clients');
});

// List of all clients
Route::get('clients', [ClientController::class, 'listClients'])->name('list.clients');

// Import client from CSV
Route::get('/clients/import', [ClientController::class, 'showImportForm'])->name('clients.import.form');
Route::post('/clients/import', [ClientController::class, 'importCSV'])->name('clients.import.csv');

// Duplicate clients
Route::get('clients/duplicate-records', [ClientController::class, 'duplicateClients'])->name('duplicate-clients');
Route::patch('clients/duplicate-records/{clientId}', [ClientController::class, 'updateDuplicateClient'])->name('update.duplicate-clients');
Route::delete('clients/duplicate-records/{clientId}', [ClientController::class, 'deleteDuplicateClient'])->name('delete.duplicate-clients');

// Export client from CSV
Route::get('/clients/export', [ClientController::class, 'exportCSV'])->name('clients.export.csv');