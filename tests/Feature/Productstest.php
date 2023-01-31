<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Productstest extends TestCase
{

    public function test_homepage_contains_empty_table()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('no products on the table');

        return($response);
    }
    public function test_homepage_contains_non_empty_table()
    {
        Product::create([
            'name' => 'Product 1',
            'price' => 300,
            'slug' => 'Product 1'
        ]);
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('no products on the table');
    }
}
