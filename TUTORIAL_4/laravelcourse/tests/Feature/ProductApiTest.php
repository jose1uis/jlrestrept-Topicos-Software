<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_product(): void
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Mechanical keyboard',
            'price' => 250,
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('name', 'Mechanical keyboard')
            ->assertJsonPath('price', 250)
            ->assertJsonStructure(['id', 'name', 'price', 'created_at', 'updated_at']);

        $this->assertDatabaseHas('products', [
            'name' => 'Mechanical keyboard',
            'price' => 250,
        ]);
    }

    public function test_name_and_price_are_required(): void
    {
        $this->postJson('/api/products', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'price']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_price_must_be_a_positive_integer(): void
    {
        $this->postJson('/api/products', [
            'name' => 'Invalid product',
            'price' => 0,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('price');

        $this->assertDatabaseCount('products', 0);
    }
}
