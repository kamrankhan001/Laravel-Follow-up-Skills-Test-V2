<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Product List</title>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Page Header -->
    <header class="bg-green-700 text-white py-6 shadow-md max-w-7xl mx-auto">
        <div class="px-4">
            <h1 class="text-3xl font-bold">Product Entry & Listing</h1>
        </div>
    </header>
    <!-- End Page Header -->


    <!-- Content Section -->
    <main class="max-w-7xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg p-6">

            <!-- Grid Layout for Form & Table -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Left: Product Form -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-green-700 text-center">Add New Product</h2>

                    <form id="productForm" class="space-y-4">
                        <input type="text" name="product_name" placeholder="Product Name" class="w-full border rounded p-2" required>
                        <input type="number" name="quantity" placeholder="Quantity in Stock" class="w-full border rounded p-2" required>
                        <input type="number" name="price" placeholder="Price per Item" class="w-full border rounded p-2" step="0.01" required>
                        <div class="text-right">
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition cursor-pointer">Add Product</button>
                        </div>
                    </form>
                </div>

                <!-- Right: Product Table -->
                <div class="overflow-x-auto">
                    <h2 class="text-xl font-semibold mb-4 text-green-700 text-center">Product List</h2>

                    <table class="min-w-full text-sm border border-gray-300">
                        <thead class="bg-green-100 text-green-800 font-semibold">
                            <tr>
                                <th class="border px-4 py-2 text-left">Product Name</th>
                                <th class="border px-4 py-2 text-left">Quantity</th>
                                <th class="border px-4 py-2 text-left">Price</th>
                                <th class="border px-4 py-2 text-left">Date</th>
                                <th class="border px-4 py-2 text-left">Total Value</th>
                                <th class="border px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productTable">
                            <!-- Product rows will be injected here -->
                        </tbody>
                        <tfoot class="bg-gray-100 font-bold">
                            <tr>
                                <td colspan="4" class="text-right px-4 py-2">Total:</td>
                                <td id="totalSum" class="px-4 py-2 text-green-700">$0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div> 
            <!-- End Grid -->

        </div>
    </main>
    <!-- End Content Section -->


    <!-- AJAX Script -->
    <script>
    </script>

</body>
</html>
