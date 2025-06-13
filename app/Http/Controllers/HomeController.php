<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $products = [];
        if (Storage::exists('products.json')) {
            $products = json_decode(Storage::get('products.json'), true);
            // Sort products by date in descending order (newest first)
            usort($products, function ($a, $b) {
                return strtotime($b['submitted_at']) - strtotime($a['submitted_at']);
            });
        }
        return view("home", compact("products"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $data = [
            'product_name' => $validated['product_name'],
            'quantity' => (int) $validated['quantity'],
            'price' => (float) $validated['price'],
            'submitted_at' => now()->toDateTimeString(),
            'total_value' => (float) $validated['quantity'] * $validated['price'],
        ];

        // Read existing products
        $products = [];
        if (Storage::exists('products.json')) {
            $products = json_decode(Storage::get('products.json'), true);
        }

        // Add new product to the beginning of the array (to show at top)
        array_unshift($products, $data);

        // Save back
        Storage::put('products.json', json_encode($products, JSON_PRETTY_PRINT));

        return response()->json([
            'status' => 'success',
            'products' => $products,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'index' => 'required|integer',
        ]);

        $products = [];
        if (Storage::exists('products.json')) {
            $products = json_decode(Storage::get('products.json'), true);
        }

        $products[$validated['index']] = [
            'product_name' => $validated['product_name'],
            'quantity' => (int) $validated['quantity'],
            'price' => (float) $validated['price'],
            'submitted_at' => now()->toDateTimeString(),
            'total_value' => (float) $validated['quantity'] * $validated['price'],
        ];

        // Re-sort after update
        usort($products, function ($a, $b) {
            return strtotime($b['submitted_at']) - strtotime($a['submitted_at']);
        });

        Storage::put('products.json', json_encode($products, JSON_PRETTY_PRINT));

        return response()->json([
            'status' => 'success',
            'products' => $products,
        ]);
    }
}