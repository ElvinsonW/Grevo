<x-layout>
    @if(session('loginSuccess'))
        <div 
            class="alert absolute z-40 flex items-center justify-center p-4 mb-4 w-[30vw] text-green-800 rounded-lg bg-green-50" 
            style="top: 10%; left: 50%; transform: translate(-50%, -50%);" 
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ session('loginSuccess') }}
            </div>
            <button type="button" class="close-button ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <div class="flex flex-col justify-center items-center bg-yellow-2">
        @if (!request()->query())
            <img src="{{ asset('images/product_banner.png') }}" alt="banner" class="w-full h-[40vw]">
        @endif
        <div
            class="w-fit px-[7vw] py-[1.5vw] rounded-[1vw] bg-yellow-2 {{ !request()->query() ? 'mt-[-6vw]' : '' }} mb-[3vw]">
            <h1 class="text-[5vw] font-bold text-green-2">GREVO CATALOGUE</h1>
        </div>
        <div class="flex w-full px-[5vw] gap-[6vw]">
            <div class="flex flex-col gap-[2vw]">
                <div
                    class="flex flex-col bg-green-1 w-[18vw] px-[1.5vw] py-[1.5vw] rounded-[0.5vw] text-green-2 shadow-lg">
                    <h2 class="text-[2vw] font-bold ">CATEGORY</h2>
                    <div class="w-full border-b-2 border-green-2 mt-[0.5vw] mb-[1vw]"></div>
                    <div class="flex flex-col gap-[0.5vw]">
                        @php
                            $hasCategoryQuery = request()->query('category') != null;
                        @endphp
                        <div class="flex items-center gap-[1vw] {{ $hasCategoryQuery ? 'ml-[2vw]' : '' }}">
                            @php
                                $queryParams = request()->query();
                            @endphp
                            @if (!$hasCategoryQuery)
                                <i class="fa-solid fa-bag-shopping"></i>
                                <a href="{{ url('products') . '?' . http_build_query($queryParams) }}"
                                    class="font-bold">All Product</a>
                            @else
                                @php
                                    unset($queryParams['category']);
                                @endphp
                                <a href="{{ url('products') . '?' . http_build_query($queryParams) }}">All Product</a>
                            @endif
                        </div>
                        @foreach ($categories as $category)
                            @php
                                $isActive = request()->query('category') == $category->slug;
                                $queryParams = request()->query();
                                $queryParams['category'] = $category->slug;
                                unset($queryParams['page']);
                            @endphp


                            <div class="flex items-center gap-[1vw] {{ $isActive ? '' : 'ml-[2vw]' }}">

                                @if ($isActive)
                                    @php
                                        unset($queryParams['category']);
                                    @endphp
                                    <i class="fa-solid fa-bag-shopping"></i>
                                    <a href="{{ url('products') . '?' . http_build_query($queryParams) }}"
                                        class="font-bold">{{ $category->name }}</a>
                                @else
                                    <a
                                        href="{{ url('products') . '?' . http_build_query($queryParams) }}">{{ $category->name }}</a>
                                @endif
                            </div>
                        @endforeach

                    </div>
                </div>

                <div
                    class="flex flex-col bg-green-1 w-[18vw] px-[1.5vw] py-[1.5vw] rounded-[0.5vw] text-green-2 shadow-lg">
                    <h2 class="text-[2vw] font-bold ">FILTER</h2>
                    <div class="w-full border-b-2 border-green-2 mt-[0.5vw] mb-[1vw]"></div>
                    <div class="flex flex-col gap-[0.75vw]">
                        <form class="flex flex-col gap-[1vw]">
                            @php
                                $params = ['category', 'search'];
                            @endphp

                            @foreach ($params as $param)
                                @if ($param)
                                    <input type="hidden" name="{{ $param }}" value="{{ request($param) }}" >    
                                @endif
                            @endforeach
                            <div class="flex items-center gap-[0.5vw]">
                                <i class="fa-solid fa-money-bill text-green-3 text-[1.5vw]"></i>
                                <h3 class="text-[1.3vw] font-bold">HARGA</h3>
                            </div>

                            <input type="number" name="min_price" value="{{ request('min_price') }}"
                                class="px-[1vw] py-[0.5vw] rounded-[0.5vw] border border-green-2 focus:outline-none"
                                placeholder="Minimum Harga">
                            <input type="number" name="max_price" value="{{ request('max_price') }}"
                                class="px-[1vw] py-[0.5vw] rounded-[0.5vw] border border-green-2 focus:outline-none"
                                placeholder="Maximum Harga">

                            <div class="flex items-center gap-[0.5vw]">
                                <i class="fa-solid fa-star text-yellow-400 text-[1.3vw]"></i>
                                <h3 class="text-[1.3vw] font-bold">RATING</h3>
                            </div>
                            
                            <input type="number" name="min_rating" value="{{ request('min_rating') }}"
                                min="1" max="5"
                                class="px-[1vw] py-[0.5vw] rounded-[0.5vw] border border-green-2 focus:outline-none"
                                placeholder="Minimum Rating">
                            <button
                                class="w-[50%] h-[3vw] rounded-[0.5vw] bg-green-2 font-bold text-white mt-[1vw]">Apply</button>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex flex-wrap gap-[1.5vw]">
                    @foreach ($products as $product)
                        @include("components.product-card", ["product" => $product])
                    @endforeach

                </div>
                <div class="w-full mt-[3vw]">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>
