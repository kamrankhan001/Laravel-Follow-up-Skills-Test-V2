<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getProducts(): array
    {
        if (!Storage::exists('products.json')) {
            return [];
        }

        $products = json_decode(Storage::get('products.json'), true);
        usort($products, function ($a, $b) {
            return strtotime($b['submitted_at']) - strtotime($a['submitted_at']);
        });

        return $products;
    }

    public function saveProducts(array $products): void
    {
        Storage::put('products.json', json_encode($products, JSON_PRETTY_PRINT));
    }
}