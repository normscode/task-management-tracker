<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Engagement;
use Illuminate\Database\Seeder;

class EngagementSeeder extends Seeder
{
    public function run(): void
    {
        $maria = Client::where('email', 'maria.santos@example.com')->first();
        $juan = Client::where('email', 'juan.delacruz@example.com')->first();
        $abc = Client::where('email', 'abc.partners@example.com')->first();
        $brightFuture = Client::where('email', 'bright.future@example.com')->first();

        Engagement::create([
            'client_id' => $maria->id,
            'service_type' => 'Tax Preparation',
            'tax_year' => 2025,
            'start_date' => '2026-01-15',
            'due_date' => '2026-04-15',
            'status' => 'Open',
            'notes' => 'Annual tax preparation engagement.',
        ]);

        Engagement::create([
            'client_id' => $maria->id,
            'service_type' => 'Bookkeeping',
            'tax_year' => 2025,
            'start_date' => '2026-01-05',
            'due_date' => '2026-03-31',
            'status' => 'In Progress',
            'notes' => 'Monthly bookkeeping review.',
        ]);

        Engagement::create([
            'client_id' => $juan->id,
            'service_type' => 'Tax Consultation',
            'tax_year' => 2025,
            'start_date' => '2026-02-01',
            'due_date' => '2026-03-15',
            'status' => 'Completed',
            'notes' => 'Consultation regarding annual tax filing.',
        ]);

        Engagement::create([
            'client_id' => $abc->id,
            'service_type' => 'Payroll',
            'tax_year' => 2025,
            'start_date' => '2026-01-10',
            'due_date' => '2026-12-31',
            'status' => 'In Progress',
            'notes' => 'Payroll processing and reporting.',
        ]);

        Engagement::create([
            'client_id' => $brightFuture->id,
            'service_type' => 'Tax Preparation',
            'tax_year' => 2025,
            'start_date' => '2026-02-10',
            'due_date' => '2026-04-15',
            'status' => 'Open',
            'notes' => 'Nonprofit annual tax preparation.',
        ]);
    }
}
