<?php

use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\{postJson, putJson, get};

beforeEach(function () {
    Storage::fake('local');
});

it('loads the home page and shows empty products', function () {
    $response = get(route('home'));

    $response->assertStatus(200);
    $response->assertViewIs('home');
    $response->assertViewHas('products', []);
});

it('stores a new product', function () {
    $data = [
        'product_name' => 'Keyboard',
        'quantity' => 2,
        'price' => 1500,
    ];

    $response = postJson(route('product.store'), $data);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ]);

    // Assert file saved
    Storage::assertExists('products.json');

    $saved = json_decode(Storage::get('products.json'), true);
    expect($saved)->toHaveCount(1);
    expect($saved[0]['product_name'])->toBe('Keyboard');
    expect($saved[0]['total_value'])->toEqual(3000.0);
});

it('updates a product at specific index', function () {
    // Initial fake data
    $products = [[
        'product_name' => 'Old Product',
        'quantity' => 1,
        'price' => 100,
        'submitted_at' => now()->subDay()->toDateTimeString(),
        'total_value' => 100,
    ]];

    Storage::put('products.json', json_encode($products));

    $updateData = [
        'product_name' => 'Updated Product',
        'quantity' => 3,
        'price' => 200,
        'index' => 0,
    ];

    $response = putJson(route('product.update'), $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ]);

    $updated = json_decode(Storage::get('products.json'), true);

    expect($updated)->toHaveCount(1);
    expect($updated[0]['product_name'])->toBe('Updated Product');
    expect($updated[0]['total_value'])->toEqual(600.0);
});
