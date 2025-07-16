<header class="flex items-center justify-around w-full h-[9vw] px-[5vw] bg-green-1">
    <a href="/">
        <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-[10vw]">
    </a>
    <div class="flex flex-col items-center justify-center gap-[0.75vw]">
        <form action="/products" method="GET"  class="flex items-center gap-[0.5vw] pl-[1vw] pr-[0.5vw] w-[60vw] h-[3vw] bg-yellow-2">
            @php
                $params = ["category","max_price","min_price","min_rating"];
            @endphp
            @foreach ($params as $param)
                @if (request($param))
                    <input type="hidden" value="{{ request($param) }}" name="{{ $param }}">
                @endif
            @endforeach
            <input type="text" name="search" value="{{ request()->query('search') }}" id="search" class="w-[90%] focus:outline-none">

            <button class="cursor-pointer px-[2vw] py-[0.25vw] bg-green-1 text-white">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
        <li class="list-none flex gap-[3vw] text-green-3 text-[1.2vw] font-bold mt-[0.25vw]">
            <a href="/" class="pb-[0.5vw] px-[1vw] {{ request()->is('/') ? 'border-b-3 border-orange-1 text-orange-1' : 'text-green-3 hover:text-green-2' }}">Home</a>
            <a href="/products" class="pb-[0.5vw] px-[1vw] {{ request()->is(['products', 'products/*']) ? 'border-b-3 border-orange-1 text-orange-1' : 'text-green-3 hover:text-green-2' }}">Products</a>
            <a href="/trees" class="pb-[0.5vw] px-[1vw] {{ request()->is(['trees', 'trees/*']) ? 'border-b-3 border-orange-1 text-orange-1' : 'text-green-3 hover:text-green-2' }}">Green Activity</a>
            <a href="/carbon-calculator" class="pb-[0.5vw] px-[1vw] {{ request()->is(['carbon-calculator', 'carbon-calculator/*']) ? 'border-b-3 border-orange-1 text-orange-1' : 'text-green-3 hover:text-green-2' }}">Carbon Calculator</a>
        </li>
    </div>

    <a href="/cart">
        <i class="fa-solid fa-cart-shopping text-[2vw] text-green-3"></i>
    </a>
    <div class="">
        @auth
            <a href="/profile" class="flex items-center gap-[0.5vw]">
                <i class="fa-solid fa-user text-[2vw] text-green-3"></i>
                <p class="font-bold text-green-3">{{ auth()->user()->username }}</p>    
            </a>
        @else
            <button class="">
                <a href="{{ route('login') }}" 
                    class="bg-green-2 text-white border-none rounded-md px-6 py-2 text-sm font-semibold cursor-pointer inline-block leading-normal hover:bg-green-3 transition-colors duration-300">SIGN
                    IN</a>
            </button>
        @endif
    </div>
</header>