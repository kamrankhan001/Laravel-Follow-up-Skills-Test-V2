
# Laravel Product Entry & Listing (JSON-based)

This is a simple Laravel-based web application for adding, updating, and listing products. All data is stored in a `products.json` file within Laravel's storage system — no database required.

## 🚀 Features

- Add new products with name, quantity, and price
- Edit existing product entries
- Calculate and show total value per product
- Show total value for all products
- Store data in a JSON file (no database)
- Fully responsive UI using Tailwind CSS
- Basic validation and error messages
- Real-time updates via JavaScript (AJAX)

## 🛠 Tech Stack

- Laravel 12+
- Tailwind CSS
- JavaScript (vanilla)
- JSON file storage (`storage/app/products.json`)

## 📂 Folder Structure

```
├── app/
│   └── Http/
│       └── Controllers/
│           └── HomeController.php
├── resources/
│   └── views/
│       └── home.blade.php
├── routes/
│   └── web.php
├── storage/
│   └── app/
│       └── products.json
```

## ⚙️ Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/kamrankhan001/laravel-json-storage.git
   cd your-repo
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Give Storage Permission**
   ```bash
   chmod -R 775 storage
   ```

5. **Run the Server**
   ```bash
   php artisan serve
   ```

6. **Visit the App**
   Open `http://localhost:8000` in your browser.

## 🧪 Routes

| Method | URI             | Description       |
|--------|------------------|-------------------|
| GET    | `/`              | Show product list |
| POST   | `/product/store`         | Add new product   |
| PUT    | `/product/update`| Update product    |

## 📌 Notes

- All product data is stored in `storage/app/products.json`
- Ensure this file is writable by the web server
- You can customize this to use a database later if needed

## Author

Kamran Khan  
[GitHub](https://github.com/kamrankhan001)
