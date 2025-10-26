<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DuplicateDetectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_flags_duplicate_clients_correctly()
    {
        // Create an existing client
        Client::factory()->create([
            'company_name' => 'Test Company',
            'email' => 'test@example.com',
            'phone_number' => '1234567890',
        ]);

        // Simulate CSV import data
        $newClientData = [
            'company_name' => 'Test Company',
            'email' => 'test@example.com',
            'phone_number' => '1234567890',
        ];

        // Check if it’s duplicate
        $isDuplicate = Client::where('company_name', $newClientData['company_name'])
            ->where('email', $newClientData['email'])
            ->where('phone_number', $newClientData['phone_number'])
            ->exists();

        $this->assertTrue($isDuplicate);
    }
}
