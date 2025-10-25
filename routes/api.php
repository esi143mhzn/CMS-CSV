<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;

Route::get('/clients', [ClientController::class, 'listClients']);
Route::post('/clients/import', [ClientController::class, 'importCSV']);

Route::get('clients/duplicate-records', [ClientController::class, 'duplicateClients']);
Route::patch('clients/duplicate-records/{clientId}', [ClientController::class, 'updateDuplicateClient']);
Route::delete('clients/duplicate-records/{clientId}', [ClientController::class, 'deleteDuplicateClient']);

Route::get('/clients/export', [ClientController::class, 'exportCSV']);

