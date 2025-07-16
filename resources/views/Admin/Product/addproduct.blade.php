<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    @vite('resources/css/app.css')
</head>
<body class="p-4 bg-yellow-2">
    @include('components.sidebar')
    @livewire('add-product')
    @livewireScripts
</body>
</html>
