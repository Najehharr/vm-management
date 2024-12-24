<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Vm;
class VmTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_vms()
    {
        // Arrange
        Vm::factory()->count(3)->create();

        // Act
        $response = $this->getJson('/api/vms');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonCount(3); // Expect 3 records in the response
    }

    /** @test */
    public function it_can_create_a_vm()
    {
        // Arrange
        $data = [
            'price' => 100.50,
            'ram' => '16GB',
            'disk' => '500GB',
            'os' => 'Ubuntu',
            'server_id' => 1,
            'client_id' => '1115032',
            'allocation_id' => 1,
        ];

        // Act
        $response = $this->postJson('/api/vms', $data);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonFragment($data);
    }
}
