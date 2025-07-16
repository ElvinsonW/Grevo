<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')

    <title>Document</title>

    @livewireStyles

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Font Quicksand --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Quicksand:wght@300..700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-yellow-2 font-quicksand">
    <x-navbar></x-navbar>
    {{ $slot }}

    <script>
        const closeButtons = document.querySelectorAll('.close-button');

        closeButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const alert = button.closest('.alert')
                alert.style.display = "none";
            });
        });
    </script>
</body>

</html>
