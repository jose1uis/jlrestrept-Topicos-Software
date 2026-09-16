<?php

namespace Tests\Feature;

use Tests\TestCase;

class OptionalActivitiesTest extends TestCase
{
    public function test_contact_page_displays_contact_information(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('Name:')
            ->assertSee('Address:')
            ->assertSee('Phone:');
    }

    public function test_navigation_contains_optional_links(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('home.contact'), false)
            ->assertSee(route('product.index'), false)
            ->assertSee(route('product.create'), false);
    }

    public function test_product_displays_price_and_expensive_product_in_red(): void
    {
        $this->get('/products/1')
            ->assertOk()
            ->assertSee('Price: $120')
            ->assertSee('text-danger', false);
    }

    public function test_invalid_product_redirects_to_home(): void
    {
        $this->get('/products/100')
            ->assertRedirect(route('home.index'));
    }

    public function test_product_price_must_be_greater_than_zero(): void
    {
        $this->from('/products/create')
            ->post('/products/save', ['name' => 'Test product', 'price' => 0])
            ->assertRedirect('/products/create')
            ->assertSessionHasErrors('price');
    }

    public function test_valid_product_displays_success_message(): void
    {
        $this->post('/products/save', ['name' => 'Test product', 'price' => 10])
            ->assertOk()
            ->assertSee('Product created successfully!')
            ->assertSee('Test product')
            ->assertSee('$10');
    }
}
