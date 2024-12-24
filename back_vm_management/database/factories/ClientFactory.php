<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'cin' => $this->faker->unique()->numerify('########'), 
            'name' => $this->faker->lastName,
            'forname' => $this->faker->firstName,
            'address' => $this->faker->address,
        ];
    }
}

