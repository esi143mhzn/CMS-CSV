<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function import_clients_from_csv()
    {
        Storage::fake('local');

        $csv = "company_name,email,phone_number\nExample Co,example@example.com,9876543210";
        $file = UploadedFile::fake()->createWithContent('clients.csv', $csv, 'text/csv');

        $response = $this->post(route('clients.import.csv'), [
            'csv_file' => $file,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('clients', ['email' => 'example@example.com']);
    }
}
