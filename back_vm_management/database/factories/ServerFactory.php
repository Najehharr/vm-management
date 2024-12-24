<?php

namespace Database\Factories;
use App\Models\Server;
use App\Models\Allocation;
use App\Models\Client;
use App\Models\Vm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Server>
 */
class ServerFactory extends Factory
{
    protected $model = Server::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ram' => $this->faker->randomElement(['8GB', '16GB', '32GB']), // Example RAM options
            'disk' => $this->faker->randomElement(['256GB SSD', '512GB SSD', '1TB HDD']), // Example disk options
            'allocation_id' => Allocation::factory(), // Create an associated allocation
            'client_cin' => Client::factory()->create()->cin, // Create a client and use its CIN
            'vm_id' => Vm::factory(), // Create an associated VM
            'begin_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'), // Random past date
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'), // Random future date
            'amount' => $this->faker->randomFloat(2, 50, 1000), // Random amount between 50 and 1000
        ];
    }
}
