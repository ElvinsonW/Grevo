<!-- NEW YA BANG GW TAMBAHIN PAGE INI -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up to GREVO</title>
    {{-- Font Inter sudah diimpor via @theme di app.css (jika ada), tapi untuk kepastian dan fallback, bisa tetap di sini --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')

    <style>
        body {
            /* Menggunakan variabel CSS untuk font-sans dari app.css, atau Inter jika tidak didefinisikan di @theme */
            font-family: var(--font-sans, 'Inter', sans-serif);
            background-image: url('{{ asset('images/loginandregBG.png') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            /* Mengatur warna background body ke warna krem butek*/
            background-color: var(--color-yellow-2);
        }
    </style>
</head>
{{-- Menghapus kelas 'font-inter' dari body karena font diatur via style tag dengan var() --}}

<body class="min-h-screen flex items-center justify-center relative bg-gray-100 py-[10vw]">
    
    {{-- Logo Grevo di kiri atas --}}
    <div class="absolute top-10 left-10 z-10">
        <img src="{{ asset('images/GrevoHD.svg') }}" alt="Grevo Logo" class="h-15">
    </div>

    {{-- Tombol Sign In di kanan atas --}}
    <div class="absolute top-10 right-10 z-10">
        <a href="{{ route('login') }}" style="background-color: var(--color-green-1); color: var(--color-green-3);"
            class="border-none rounded-md px-6 py-2 text-sm font-semibold cursor-pointer inline-block leading-normal hover:bg-gray-400 transition-colors duration-300">SIGN
            IN</a>
    </div>

    {{-- Card utama untuk form Sign Up --}}
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-10 text-center relative z-20">
        <h2 class="text-2xl text-gray-800 mb-2 font-semibold">Sign up to GREVO</h2>
        <p class="text-sm text-gray-600 mb-8">Quick & Simple way to your online shopping</p>

        {{-- Pesan sukses (misalnya dari redirect setelah register) --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 border border-green-300 px-4 py-3 rounded-md mb-5 text-sm"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf {{-- CSRF token buat keamanan form --}}

            {{-- Field NAME --}}
            <div class="mb-5 text-left">
                <label for="name" class="block text-xs text-gray-700 uppercase font-semibold mb-1">NAME</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ivy"
                    required autocomplete="name" autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-[var(--color-green-3)]"
                    style="border-color: var(--color-green-3);"> {{-- Menggunakan --color-green-3 dari app.css untuk fokus --}}
                @error('name')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Field USERNAME --}}
            <div class="mb-5 text-left">
                <label for="username" class="block text-xs text-gray-700 uppercase font-semibold mb-1">USERNAME</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Ivy"
                    required autocomplete="name" autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-[var(--color-green-3)]"
                    style="border-color: var(--color-green-3);"> {{-- Menggunakan --color-green-3 dari app.css untuk fokus --}}
                @error('username')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Field GENDER --}}
            <div class="mb-5 text-left">
                <label for="gender" class="block text-xs text-gray-700 uppercase font-semibold mb-1">GENDER</label>
                <div class="relative">
                    <select id="gender" name="gender"
                        class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-[var(--color-green-3)]"
                        style="border-color: var(--color-green-3);" {{-- Menggunakan --color-green-3 dari app.css untuk fokus --}} required>
                        <option value="" disabled selected hidden>Select a category...</option>
                        @if (old('gender') == 'male')
                            <option value="male" selected class="text-black">Male</option>
                        @else
                            <option value="male" class="text-black">Male</option>
                        @endif

                        @if (old('gender') == 'female')
                            <option value="female" selected class="text-black">Female</option>
                        @else
                            <option value="female" class="text-black">Female</option>
                        @endif
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                @error('phone_number')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Field EMAIL ADDRESS --}}
            <div class="mb-5 text-left">
                <label for="email" class="block text-xs text-gray-700 uppercase font-semibold mb-1">EMAIL
                    ADDRESS</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="ivy@stay.com" required autocomplete="email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-[var(--color-green-3)]"
                    style="border-color: var(--color-green-3);">
                @error('email')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Field Phone Number --}}
            <div class="mb-5 text-left">
                <label for="phone_number" class="block text-xs text-gray-700 uppercase font-semibold mb-1">PHONE NUMBER</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                    placeholder="085263506419" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-[var(--color-green-3)]"
                    style="border-color: var(--color-green-3);">
                @error('phone_number')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Field Address --}}
            <div class="mb-5 text-left">
                <label for="address" class="block text-xs text-gray-700 uppercase font-semibold mb-1">ADDRESS</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}"
                    placeholder="Jalan Pakuan 3" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-[var(--color-green-3)]"
                    style="border-color: var(--color-green-3);">
                @error('address')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Field PASSWORD si toggle mata-mata --}}
           
            <div class="mb-5 text-left">
                <label for="password"
                    class="block text-xs text-gray-700 uppercase font-semibold mb-1">PASSWORD</label>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="********" required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-[var(--color-green-3)]"
                        style="border-color: var(--color-green-3);">
                    <div class="absolute right-4 top-[0.6vw] cursor-pointer text-gray-400 text-lg p-1"
                        onclick="togglePasswordVisibility('password')">
                        <i class="fa-solid fa-eye-slash"></i>
                    </div>
                </div>
                @error('password')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Field CONFIRM PASSWORD ya --}}
            <div class="mb-8 text-left">
                <label for="password_confirmation"
                    class="block text-xs text-gray-700 uppercase font-semibold mb-1">CONFIRM PASSWORD</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="********" required autocomplete="new-password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-[var(--color-green-3)]"
                        style="border-color: var(--color-green-3);">
                    <span class="absolute right-4 top-[0.75vw] cursor-pointer text-gray-400 text-lg p-1"
                        onclick="togglePasswordVisibility('password_confirmation')">
                        <i class="fa-solid fa-eye-slash"></i>
                    </span>
                </div>
                @error('password')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Checkbox Terms & Privacy Policy : belum diarahin kemana nya bang --}}
            <div class="flex items-center mb-8 text-sm text-gray-700 text-left">
                <input type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }} required
                    class="mr-2 min-w-4 min-h-4 cursor-pointer" style="accent-color: var(--color-green-3);">
                {{-- Menggunakan --color-green-3 untuk accent-color --}}
                <label for="terms">I agree to the <a href="#" class="no-underline hover:underline"
                        style="color: var(--color-green-3);">terms of Service</a> and <a href="#"
                        class="no-underline hover:underline" style="color: var(--color-green-3);">Privacy
                        Policy</a>.</label>
            </div>

            {{-- Tombol CREATE AN ACCOUNT --}}
            <button type="submit"
                class="w-full py-3 text-white rounded-md text-base font-semibold cursor-pointer hover:bg-green-600 transition-colors duration-300"
                style="background-color: var(--color-green-2);">CREATE AN ACCOUNT</button>
        </form>
    </div>

    {{-- Copyright footer --}}
    <div class="absolute bottom-8 text-xs text-gray-500">
        © 2025 All Rights Reserved. GREVO
    </div>

    {{-- JeEs nya mata-mata --}}
    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const toggleIcon = field.nextElementSibling.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                field.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>

</html>
