<div>
    <h2 class="text-xl font-semibold mb-4 text-purple-700 text-center">Add New Product</h2>

    <form id="productForm" class="space-y-4" novalidate>
        @csrf
        <input type="hidden" name="index" id="editIndex" value="">
        <input type="hidden" name="_method" id="formMethod" value="POST">
        
        <div>
            <label for="product_name" class="block mb-2 text-sm font-medium text-gray-900">Product Name</label>
            <input type="text" id="product_name" name="product_name" placeholder="Enter product name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-200 focus:border-purple-500 block w-full p-2.5 focus:outline-none focus:ring-2 transition duration-200"
                required>
            <div class="text-sm text-red-600 error-message" data-field="product_name"></div>
        </div>

        <div>
            <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Quantity</label>
            <input type="number" id="quantity" name="quantity" placeholder="Enter quantity"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-500 transition duration-200"
                required>
            <div class="text-sm text-red-600 error-message" data-field="quantity"></div>
        </div>

        <div>
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Price</label>
            <input type="number" id="price" name="price" placeholder="Enter price per item"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-500 transition duration-200"
                step="0.01" required>
            <div class="text-sm text-red-600 error-message" data-field="price"></div>
        </div>

        <div class="text-right">
            <button type="submit"
                class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition duration-200 hover:cursor-pointer" title="Add Product">
                Add Product
            </button>
        </div>
    </form>
</div>