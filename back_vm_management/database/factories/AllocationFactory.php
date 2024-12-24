<?php

namespace Database\Factories;
use App\Models\Allocation;
use App\Models\Client;
use App\Models\Vm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Allocation>
 */
class AllocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_cin' => Client::factory()->create()->cin, // Creates a new client and uses its CIN
            'vm_id' => Vm::factory(), // Creates a new VM and uses its ID
            'begin_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'), // Random past date
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'), // Random future date
            'amount' => $this->faker->randomFloat(2, 100, 1000), // Random amount between 100 and 1000
        ];
    }
}
