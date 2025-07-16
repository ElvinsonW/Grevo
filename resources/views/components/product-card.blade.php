@php
    $avgRating = round($product->reviews_avg_rate, 1); // misalnya: 4.2
@endphp
<a href="/products/{{ $product->slug }}" class="flex flex-col w-[15vw] h-[21vw] p-[1vw] bg-green-2">
    <div class="relative w-full mb-[0.5vw]">
        <div class="w-[13vw] h-[13vw] overflow-hidden">
            <img src="{{ asset('storage/' . $product->product_images->first()->image) }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover transition-transform duration-500 hover:scale-150">
        </div>
        <p class="absolute bottom-0 right-0 bg-orange-1 px-[1vw] py-[0.5vw] text-[1vw] text-white font-semibold">
            Rp. {{ number_format($product->product_variants->first()->price) }}</p>
    </div>

    <p class="text-yellow-4 font-bold text-[0.9vw] opacity-75">
        {{ $product->product_category->name }}</p>
    <h3 class="text-[1.2vw] font-bold text-yellow-4 mb-[0.3vw]">{{ Str::limit($product->name, 15) }}</h3>
    <div class="flex items-center gap-[0.5vw] mb-[0.75vw]">
        <div class="flex items-center gap-[0.5vw]">
            <i class="fa-solid fa-star text-yellow-400 text-[1.1vw]"></i>
            <p class="text-white font-bold text-[1vw]">{{ $avgRating }}</p>
        </div>
        <div class="border-l-2 border-l-yellow-2 h-[80%]"></div>
        <p class="text-yellow-4 font-bold text-[1vw]"> {{ $product->sold }} Terjual</p>
    </div>
</a>
