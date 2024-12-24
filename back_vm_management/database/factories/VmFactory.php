<?php

namespace Database\Factories;
use App\Models\Vm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vm>
 */
class VmFactory extends Factory
{
    protected $model = Vm::class;

    public function definition()
    {
        return [
            'price' => $this->faker->randomFloat(2, 50, 500), // Random price
            'ram' => $this->faker->randomElement(['8GB', '16GB', '32GB']),
            'disk' => $this->faker->randomElement(['250GB', '500GB', '1TB']),
            'os' => $this->faker->randomElement(['Ubuntu', 'Windows', 'CentOS']),
            'server_id' => \App\Models\Server::factory(), // Assuming you have a Server model
            'client_id' => \App\Models\Client::factory(), // Assuming you have a Client model
            'allocation_id' => \App\Models\Allocation::factory(), // Assuming you have an Allocation model
        ];
    }
}
