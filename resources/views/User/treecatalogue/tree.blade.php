{{-- resources/views/User/treecatalogue/tree.blade.php --}}
<x-layout>
    <div class="flex mx-[5vw] my-[2vw] gap-[4vw]">
        {{-- Left Sidebar: Filters --}}
        <div class="w-[18vw] h-fit p-[1.5vw] pb-[3vw] bg-green-1 rounded-[1vw] mr-[2vw]">
            {{-- Form for Filters --}}
            <div class="flex flex-col text-green-2">
                <h2 class="text-[2vw] font-bold ">ORGANIZATION</h2>
                <div class="w-full border-b-2 border-green-2 mt-[0.5vw] mb-[1vw]"></div>
                <div class="flex flex-col gap-[0.5vw] ml-[0.5vw]">
                    @php
                        $hasOrganizationQuery = request()->query('organization_id') != null;
                    @endphp
                    <div class="flex items-center gap-[1vw] {{ $hasOrganizationQuery ? 'ml-[2vw]' : '' }}">
                        @php
                            $queryParams = request()->query();
                        @endphp
                        @if (!$hasOrganizationQuery)
                            <i class="fa-solid fa-bag-shopping"></i>
                            <a href="{{ url('trees') . '?' . http_build_query($queryParams) }}" class="font-bold">All
                                Organization</a>
                        @else
                            @php
                                unset($queryParams['organization_id']);
                            @endphp
                            <a href="{{ url('trees') . '?' . http_build_query($queryParams) }}">All Product</a>
                        @endif
                    </div>

                    @foreach ($organizations as $org)
                        @php
                            $isActive = request()->query('organization_id') == $org->organization_id;
                            $queryParams = request()->query();
                            $queryParams['organization_id'] = $org->organization_id;
                            unset($queryParams['page']);
                        @endphp


                        <div class="flex items-center gap-[1vw] {{ $isActive ? '' : 'ml-[2vw]' }}">

                            @if ($isActive)
                                @php
                                    unset($queryParams['organization_id']);
                                @endphp
                                <i class="fa-solid fa-bag-shopping"></i>
                                <a href="{{ url('trees') . '?' . http_build_query($queryParams) }}"
                                    class="font-bold">{{ $org->organization_name }}</a>
                            @else
                                <a
                                    href="{{ url('trees') . '?' . http_build_query($queryParams) }}">{{ $org->organization_name }}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Content --}}
        <div class="flex flex-col">
            <div class="flex items-center text-[1.2vw] font-bold text-gray-700 mb-[2vw]">
                <p>My Points:</p>
                <span class="ml-[0.5vw] text-[var(--color-green-3)]">200 pts</span>
            </div>

            {{-- Product Grid --}}
            <div>
                <div class="flex flex-wrap gap-[1.5vw]" id="products-grid">
                    @forelse ($trees as $product)
                        <a href="/trees/{{ $product->treename }}"
                            class="flex flex-col gap-3 p-[1vw] bg-green-2 w-[15vw] h-[21vw] product-card"
                            style="box-shadow: 0px 4px 4px 2px rgba(0,0,0,0.25);">
                            <div class="relative w-[13vw] h-[13vw]">
                                <img src="{{ asset('storage/' . ($product->treephoto ?? 'images/product-placeholder.jpg')) }}"
                                    alt="{{ $product->treename }}" class="w-full h-full object-cover">
                                <p class="absolute bottom-0 right-0 text-xs text-white font-bold px-3 py-1 bg-orange-1">
                                    PTS {{ number_format($product->treeprice) }}</p>
                            </div>
                            <h2 class="text-base font-bold text-white truncate text-[1.2vw]">{{ $product->treename }}</h2>
                            <p class="text-[0.8vw] text-white line-clamp-2 leading-tight">
                                {{ \Illuminate\Support\Str::limit($product->treedesc, 55) }}
                            </p>
                        </a>
                    @empty
                        <p class="text-gray-600 text-lg">No trees found matching your filters.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layout>
