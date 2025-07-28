@extends('layouts.app')

@section('title', 'Product List')

@section('content')
    <div class="bg-white rounded-lg shadow p-6" id="product-manager" data-products='@json($products)'>
        <!-- Grid Layout for Form & Table -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @include('products.partials.form')
            @include('products.partials.table')
        </div>
    </div>
@endsection