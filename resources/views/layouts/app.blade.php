<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Product Management')</title>
</head>

<body class="bg-gray-50 min-h-screen">
    @include('partials.header')
    
    <main class="max-w-7xl mx-auto py-10">
        @yield('content')
    </main>
</body>

</html>