class ProductManager {
    constructor() {
        this.products = [];
        this.form = document.getElementById("productForm");
        this.productTable = document.getElementById("productTable");
        this.totalSumEl = document.getElementById("totalSum");

        this.initialize();
    }

    initialize() {
        // Get products from data attribute
        const productsContainer = document.getElementById("product-manager");
        const productsFromPHP = JSON.parse(productsContainer.dataset.products);

        this.renderTable(productsFromPHP);
        this.form.addEventListener("submit", (e) => this.handleFormSubmit(e));
    }

    clearErrors() {
        document
            .querySelectorAll(".error-message")
            .forEach((el) => (el.textContent = ""));
    }

    renderTable(data) {
        // Sort data by date in descending order (newest first)
        data.sort(
            (a, b) => new Date(b.submitted_at) - new Date(a.submitted_at)
        );

        this.products = data;
        this.productTable.innerHTML = "";
        let totalSum = 0;

        this.products.forEach((product, index) => {
            totalSum += product.total_value;
            this.productTable.innerHTML += `
            <tr class="bg-purple-50 border-b hover:bg-purple-100">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">${
                    product.product_name
                }</td>
                <td class="px-6 py-4">${product.quantity}</td>
                <td class="px-6 py-4">$${product.price.toFixed(2)}</td>
                <td class="px-6 py-4">${new Date(
                    product.submitted_at
                ).toLocaleString("en-US")}
                <td class="px-6 py-4 text-center">
                    <button onclick="productManager.editProduct(${index})" 
                        class="font-medium text-blue-600 hover:underline hover:cursor-pointer mr-2" title="Edit Product">
                        Edit
                    </button>
                </td>
            </tr>`;
        });

        this.totalSumEl.textContent = `$${totalSum.toFixed(2)}`;
    }

    editProduct(index) {
        const product = this.products[index];
        this.form.product_name.value = product.product_name;
        this.form.quantity.value = product.quantity;
        this.form.price.value = product.price;
        document.getElementById("editIndex").value = index;
        document.getElementById("formMethod").value = "PUT";

        // Change button text
        this.form.querySelector('button[type="submit"]').textContent =
            "Update Product";
    }

    async handleFormSubmit(e) {
        e.preventDefault();
        this.clearErrors();

        const formData = new FormData(this.form);
        const isUpdate = formData.get("index");

        let url = isUpdate
            ? "/product/update"
            : "/product/store";

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    Accept: "application/json",
                },
                body: formData,
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw errorData;
            }

            const data = await response.json();
            if (data.status === "success") {
                // Always use the server's response to render the table
                this.renderTable(data.products);
                this.form.reset();
                document.getElementById("editIndex").value = "";
                document.getElementById("formMethod").value = "POST";
                this.form.querySelector('button[type="submit"]').textContent =
                    "Add Product";
            }
        } catch (err) {
            if (err.errors) {
                // Show validation errors
                Object.keys(err.errors).forEach((field) => {
                    const errorEl = document.querySelector(
                        `.error-message[data-field="${field}"]`
                    );
                    if (errorEl) {
                        errorEl.textContent = err.errors[field][0];
                    }
                });
            } else {
                console.error(err);
                alert("Something went wrong!");
            }
        }
    }
}

// Initialize the product manager when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    window.productManager = new ProductManager();
});
