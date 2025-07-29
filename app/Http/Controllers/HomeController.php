<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;

class HomeController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getProducts();
        return view("home", compact("products"));
    }

    public function store(ProductRequest $request)
    {
        $products = $this->productService->getProducts();
        array_unshift($products, $request->validatedData());
        $this->productService->saveProducts($products);

        return response()->json([
            'status' => 'success',
            'products' => $products,
        ]);
    }

    public function update(ProductRequest $request)
    {
        $products = $this->productService->getProducts();
        $products[$request->validated()['index']] = $request->validatedData();
        $this->productService->saveProducts($products);

        return response()->json([
            'status' => 'success',
            'products' => $products,
        ]);
    }
}