<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function listClients(Request $request) 
    {
        $filter = $request->query('filter', 'all');
        $mainQuery = $this->getFilteredClients($filter, true);

        $clients = $mainQuery;

        return response()->json($clients);
    }

    public function importCSV(Request $request) 
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $file = fopen($path, 'r');
        
        $header = fgetcsv($file);
        $expectedHeaders = ['company_name', 'email', 'phone_number'];

        if (isset($header[0])) {
            $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
        }
            
        if($header !== $expectedHeaders) {
            return response()->json([
                'error' => 'Invalid CSV header format.'
            ], 422);
        }

        // Load all existing client keys from DB
        $exisitingKeys = Client::all()->map(function($client) {
            return $client->company_name . '|' . $client->email . '|' . $client->phone_number;
        })->toArray();

        $errors = [];
        $batchData = [];
        $rowNumber = 1;
        $duplicates = [];

        while(($row = fgetcsv($file)) !== false) {
            $rowNumber++;

            $data = array_combine($expectedHeaders, $row);

            $validator = Validator::make($data, [
                'company_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone_number' => 'required|string|max:20',
            ]);

            if($validator->fails()) {
                $errors[$rowNumber] = $validator->errors()->all();
                continue;
            }

            //check duplicate with DB
            $key = $data['company_name'] . '|' . $data['email'] . '|' . $data['phone_number'];
            $isDuplicate = in_array($key, $exisitingKeys);
            if($isDuplicate) {
                $duplicates[$rowNumber] = 'Duplicate records detect and imported with flag.';
            }

            $batchData[] = [
                'company_name' => $data['company_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'is_duplicate' => $isDuplicate,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            //Batch insert every 500 records
            if(count($batchData) === 500) {
                Client::insert($batchData);
                $batchData = [];
            }
        }

        // Insert remaning records
        if(!empty($batchData)) {
            Client::insert($batchData);
        }

        fclose($file);

        if(!empty($errors) || !empty($duplicates)) {
            return response()->json([
                'error' => 'Some rows failed to import.',
                'import_errors' => $errors,
                'duplicates' => $duplicates,
            ], 422);
        }

        return response()->json(['message' => 'Imported successfully'], 200);
    }

    public function duplicateClients() 
    {
        $duplicateClients = Client::where('is_duplicate', 1)->orderBy('created_at', 'desc')->paginate(25);

        return response()->json($duplicateClients);
    }

    public function updateDuplicateClient(Request $request, $id) 
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['company_name', 'email', 'phone_number']);

        $existingRecord = Client::find($id);

        if (!$existingRecord) {
            return response()->json([
                'message' => 'Client not found!'
            ], 404);
        }

        $change = [];
        foreach($data as $key => $value) {
            if($value != $existingRecord->$key) {
                $change[$key] = [
                    'old' => $existingRecord->$key,
                    'new' => $value,
                ];
            }
        }

        if (empty($change)) {
            return response()->json([
                'message' => 'No data updates, so data remains the same.'
            ]);
        }
        
        $existingRecord->fill($data);
        $existingRecord->is_duplicate = 0;
        $existingRecord->save();

        return response()->json([
            'message' => 'Duplicate Client updated and moved to client list successfully!',
            'change' => $change,
        ]);
    }

    public function deleteDuplicateClient($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        $client->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Duplicate client deleted successfully.'
        ], 200);
    }

    public function exportCSV(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $mainQuery = $this->getFilteredClients($filter, false);

        $filename = 'clients_export_' . date('Ymd_His') . '.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['S.N.', 'Company Name', 'Email', 'Phone Number']);
        
        $counter = 1;
        $mainQuery->chunk(1000, function ($clients) use (&$counter, $handle) {
            foreach($clients as $client)
            {
                fputcsv($handle, [
                    $counter++,
                    $client->company_name,
                    $client->email,
                    $client->phone_number
                ]);
            }
        });

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    private function getFilteredClients($filter, $paginate = false)
    {
        $filterQuery = Client::query()->orderBy('updated_at', 'desc');

        if($filter === 'duplicates') {
            $filterQuery->where('is_duplicate', 1);
        } else if ($filter === 'unique') {
            $filterQuery->where('is_duplicate', 0);
        }

        return $paginate ? $filterQuery->paginate(25) : $filterQuery;
    }
}
