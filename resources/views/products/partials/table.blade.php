<div class="overflow-x-auto pb-2">
    <h2 class="text-xl font-semibold mb-4 text-purple-700 text-center">Product List</h2>

    <div class="relative shadow-md sm:rounded-lg">
        <div class="overflow-y-auto max-h-[calc(100vh-300px)] scrollbar-thin scrollbar-thumb-purple-300 scrollbar-track-purple-50 hover:scrollbar-thumb-purple-400">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-purple-700 uppercase bg-purple-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3">Product Name</th>
                        <th class="px-6 py-3">Quantity</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>

                <tbody id="productTable" class="divide-y divide-gray-200">
                    <!-- Product rows injected here -->
                </tbody>

                <tfoot class="bg-purple-50 sticky bottom-0 z-10 border-t border-purple-100">
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-right text-purple-700 font-semibold">Total:</td>
                        <td id="totalSum" class="px-6 py-3 font-bold text-purple-800">$0.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
