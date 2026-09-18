<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'entity_type' => fake()->randomElement([
                'Individual',
                'LLC',
                'Corporation',
                'Partnership',
                'Nonprofit',
            ]),
            'status' => fake()->randomElement([
                'Active',
                'Inactive',
            ]),
        ];
    }
}
