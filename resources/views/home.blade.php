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

                    <form id="productForm" class="space-y-4" novalidate>
                        @csrf
                        <input type="hidden" name="index" id="editIndex" value="">
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <div>
                            <input type="text" name="product_name" placeholder="Product Name"
                                class="w-full border rounded p-2" required>
                            <div class="text-sm text-red-600 error-message" data-field="product_name"></div>
                        </div>

                        <div>
                            <input type="number" name="quantity" placeholder="Quantity in Stock"
                                class="w-full border rounded p-2" required>
                            <div class="text-sm text-red-600 error-message" data-field="quantity"></div>
                        </div>

                        <div>
                            <input type="number" name="price" placeholder="Price per Item"
                                class="w-full border rounded p-2" step="0.01" required>
                            <div class="text-sm text-red-600 error-message" data-field="price"></div>
                        </div>

                        <div class="text-right">
                            <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition cursor-pointer">
                                Add Product
                            </button>
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
        let products = [];
        let form;

        window.editProduct = function (index) {
            const product = products[index];
            form.product_name.value = product.product_name;
            form.quantity.value = product.quantity;
            form.price.value = product.price;
            document.getElementById('editIndex').value = index;
            document.getElementById('formMethod').value = 'PUT';

            // Change button text
            form.querySelector('button[type="submit"]').textContent = 'Update Product';
        }

        document.addEventListener('DOMContentLoaded', () => {
            form = document.getElementById('productForm');
            const productTable = document.getElementById('productTable');
            const totalSumEl = document.getElementById('totalSum');

            // Clear previous error messages
            function clearErrors() {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            }

            function renderTable(data) {
                // Sort data by date in descending order (newest first)
                data.sort((a, b) => new Date(b.submitted_at) - new Date(a.submitted_at));
                
                products = data;
                productTable.innerHTML = '';
                let totalSum = 0;

                products.forEach((product, index) => {
                    totalSum += product.total_value;
                    productTable.innerHTML += `
                    <tr>
                        <td class="border px-4 py-2">${product.product_name}</td>
                        <td class="border px-4 py-2">${product.quantity}</td>
                        <td class="border px-4 py-2">$${product.price.toFixed(2)}</td>
                        <td class="border px-4 py-2">${new Date(product.submitted_at).toLocaleString('en-US')}</td>
                        <td class="border px-4 py-2">$${product.total_value.toFixed(2)}</td>
                        <td class="border px-4 py-2 text-center">
                            <button onclick="editProduct(${index})" class="bg-blue-500 text-white px-2 py-1 rounded text-xs cursor-pointer">Edit</button>
                        </td>
                    </tr>`;
                });

                totalSumEl.textContent = `$${totalSum.toFixed(2)}`;
            }

            // Render products on page load (from PHP passed data)
            const productsFromPHP = @json($products);
            renderTable(productsFromPHP);

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                clearErrors();

                const formData = new FormData(this);
                const isUpdate = formData.get('index');

                let url = isUpdate ? "{{ route('product.update') }}" : "{{ route('product.store') }}";
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(err => Promise.reject(err));
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        // Always use the server's response to render the table
                        renderTable(data.products);
                        form.reset();
                        document.getElementById('editIndex').value = '';
                        document.getElementById('formMethod').value = 'POST';
                        form.querySelector('button[type="submit"]').textContent = 'Add Product';
                    }
                })
                .catch(err => {
                    if (err.errors) {
                        // Show validation errors
                        Object.keys(err.errors).forEach(field => {
                            const errorEl = document.querySelector(`.error-message[data-field="${field}"]`);
                            if (errorEl) {
                                errorEl.textContent = err.errors[field][0];
                            }
                        });
                    } else {
                        console.error(err);
                        alert('Something went wrong!');
                    }
                });
            });
        });
    </script>

</body>

</html>