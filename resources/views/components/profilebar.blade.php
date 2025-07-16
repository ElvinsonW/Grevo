{{-- resources/views/components/profilebar.blade.php --}}

@props(['user']) 

<div
    class="relative flex flex-col items-center w-[16vw] shrink-0 overflow-hidden h-fit px-[1.5vw] pt-[2vw] pb-[3vw] bg-[#BEE0C7] rounded-[1vw]">
    <div class="flex flex-col items-center gap-[0.25vw] mb-[1.5vw]">
        {{-- Menghilangkan mt-[-2vw] dan memastikan gambar berada di dalam aliran normal --}}
        {{-- Jika ingin gambar sedikit 'keluar' tapi tetap di dalam area, bisa pakai mt-[-1vw] atau posisi relatif --}}
        <img src="{{ asset('storage/' . $user->image) }}" alt="profile"
            class="w-[5vw] h-[5vw] rounded-full object-cover">
        {{-- Menampilkan username user jika ada, atau 'Guest User' --}}
        <p class="text-[1.1vw] font-bold">
            {{ $user ? $user->username : 'Guest User' }}
        </p>
    </div>

    {{-- PTS Section --}}
    <div
        class="flex w-full px-[1vw] py-[0.5vw] border border-[var(--color-green-3)] text-[var(--color-green-3)] rounded-full mb-[1.2vw] items-center justify-center gap-[0.5vw]">
        <i class="fa-solid fa-star text-[0.9vw]"></i>
        {{-- poin user --}}
        <p class="text-[1vw] font-semibold">{{ $user ? $user->points : '0' }} Pts</p>
    </div>

    <div class="flex flex-col gap-[0.75vw] justify-start w-full px-[1vw]">
        <div class="flex flex-col" id="profile-menu">
            <div class="flex items-center justify-between cursor-pointer">
                <div class="flex items-center gap-[0.5vw]">
                    {{-- Ikon dengan lebar konsisten --}}
                    <i
                        class="fa-regular fa-user text-[1vw] w-[1.2vw] {{ Request::routeIs('profile') || Request::routeIs('addresses') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}"></i>
                    <p
                        class="text-[1vw] font-bold {{ Request::routeIs('profile') || Request::routeIs('addresses') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}">
                        My Account</p>
                </div>
                {{-- Ikon panah dropdown --}}
                <i class="fa-solid fa-chevron-down text-[1vw] transition-transform duration-400 rotate-180"
                    id="dropdown-icon"></i>
            </div>

        </div>
        {{-- Dropdown Links --}}
        <div class="flex flex-col gap-[0.5vw] ml-[1.7vw] mb-[0.25vw]" id="profile-dropdown">
            {{-- Link Profile (active class berdasarkan route) --}}
            <a href="{{ route('profile') }}"
                class="text-[1vw] font-bold {{ Request::routeIs('profile') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}">Profile</a>
            {{-- Link Addresses (active class berdasarkan route) --}}
            <a href="{{ route('addresses') }}"
                class="text-[1vw] font-bold {{ Request::routeIs('addresses') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}">Addresses</a>
        </div>

        {{-- Order Link --}}
        <a href="{{ route('orders') }}" class="flex items-center gap-[0.5vw]">
            <i
                class="fa-solid fa-box-open text-[1vw] w-[1.2vw] {{ Request::routeIs('orders') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}"></i>
            <p
                class="text-[1vw] font-bold {{ Request::routeIs('orders') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}">
                Order</p>
        </a>

        {{-- Review Link --}}
        <a href="{{ route('profile.reviews') }}" class="flex items-center gap-[0.5vw]">
            <i
                class="fa-regular fa-comment-dots text-[1vw] w-[1.2vw] {{ Request::routeIs('profile.reviews') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}"></i>
            <p
                class="text-[1vw] font-bold {{ Request::routeIs('profile.reviews') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}">
                Review</p>
        </a>

         <a href="{{ route('profile.tree-order') }}" class="flex items-center gap-[0.5vw]">
            <i
                class="fa-solid fa-tree text-[1vw] w-[1.2vw] {{ Request::routeIs('profile.tree-order') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}"></i>
            <p
                class="text-[1vw] font-bold {{ Request::routeIs('profile.tree-order') ? 'text-[var(--color-green-3)]' : 'text-gray-700' }}">
                Tree Order</p>
        </a>

        {{-- Logout Link (hanya tampil jika user login) atau Login Link (jika tidak login) --}}
        @auth
            <form action="{{ route('logout') }}" method="POST" class="mt-[1vw]">
                @csrf
                <button type="submit" class="flex items-center gap-[0.5vw] w-full text-left">
                    <i class="fa-solid fa-right-from-bracket text-[1vw] w-[1.2vw] text-red-600"></i>
                    <p class="text-[1vw] font-bold text-red-600">Logout</p>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="flex items-center gap-[0.5vw] mt-[1vw]"> {{-- Menggunakan route('login') --}}
                <i class="fa-solid fa-right-to-bracket text-[1vw] w-[1.2vw] text-gray-700"></i>
                <p class="text-[1vw] font-bold text-gray-700">Login</p>
            </a>
        @endauth
    </div>
</div>

{{-- Script untuk dropdown sidebar --}}
<script>
    const toggle = document.getElementById('profile-menu');
    const menu = document.getElementById('profile-dropdown');
    const icon = document.getElementById('dropdown-icon')

    toggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        menu.classList.toggle('flex');
        icon.classList.toggle('rotate-180')
    });
</script>
