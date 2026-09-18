<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::create([
            'name' => 'Maria Santos Consulting LLC',
            'email' => 'maria.santos@example.com',
            'phone' => '09171234567',
            'entity_type' => 'LLC',
            'status' => 'Active',
        ]);

        Client::create([
            'name' => 'Juan Dela Cruz Corporation',
            'email' => 'juan.delacruz@example.com',
            'phone' => '09181234567',
            'entity_type' => 'Corporation',
            'status' => 'Active',
        ]);

        Client::create([
            'name' => 'ABC Business Partners',
            'email' => 'abc.partners@example.com',
            'phone' => '09191234567',
            'entity_type' => 'Partnership',
            'status' => 'Active',
        ]);

        Client::create([
            'name' => 'Santos Family Enterprise',
            'email' => 'santos.family@example.com',
            'phone' => '09201234567',
            'entity_type' => 'Individual',
            'status' => 'Inactive',
        ]);

        Client::create([
            'name' => 'Bright Future Foundation',
            'email' => 'bright.future@example.com',
            'phone' => '09211234567',
            'entity_type' => 'Nonprofit',
            'status' => 'Active',
        ]);
    }
}
