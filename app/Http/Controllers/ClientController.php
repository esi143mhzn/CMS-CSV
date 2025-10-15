<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ClientController extends Controller
{
    public function showImportForm() 
    {
        return view('clients.import_form');
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
            return back()->with('error', 'Invalid CSV header format.');
        }

        $errors = [];
        $batchData = [];
        $rowNumber = 1;

        while(($row = fgetcsv($file)) !== false) {
            $rowNumber++;

            $data = array_combine($expectedHeaders, $row);

            $validator = Validator::make($data, [
                'company_name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'phone_number' => 'nullable|string|max:20',
            ]);

            if($validator->fails()) {
                $errors[$rowNumber] = $validator->errors()->all();
                continue;
            }

            $batchData[] = [
                'company_name' => $data['company_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            //Batch insert every 500 records
            if(count($batchData) === 500) {
                DB::table('clients')->insert($batchData);
                $batchData = [];
            }
        }

        // Insert remaning records
        if(!empty($batchData)) {
            DB::table('clients')->insert($batchData);
        }

        fclose($file);

        if(!empty($errors)) {
            return back()->with('error', 'Some rows failed to import.')->with('import_errors', $errors);
        }

        return back()->with('success', 'CSV imported successfully.'); 
    }
}
