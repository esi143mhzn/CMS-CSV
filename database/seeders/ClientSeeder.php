<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Client::insert([
            [
                'company_name' => 'ABC Pvt Ltd',
                'email' => 'abc@example.com',
                'phone_number' => '9800000001',
                'is_duplicate' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'XYZ Co',
                'email' => 'xyz@example.com',
                'phone_number' => '9800000002',
                'is_duplicate' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
