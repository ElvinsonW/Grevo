{{-- Assuming this component receives a $tree variable --}}
<a href="{{ route('tree.see', ['treeName' => $tree->treename]) }}" class="flex flex-col w-[20vw] h-[26vw] rounded-[1vw] overflow-hidden" style="box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06);">
    <img src="{{ asset('storage/' . $tree->treephoto) }}" alt="{{ $tree->treename }}" class="w-full h-[15vw] object-cover">
    <div class="p-[1vw] flex flex-col justify-between flex-grow">
        <h3 class="font-bold text-[#3E6137] text-[1.2vw] mb-[0.5vw]">{{ $tree->treename }}</h3>
        <p class="text-gray-600 text-[0.9vw] line-clamp-2 mb-[1vw]">{{ $tree->treedesc }}</p>
        <div class="flex justify-between items-center mt-auto">
            <p class="text-red-600 font-bold text-[1.1vw]">Rp {{ number_format($tree->treeprice) }}</p>
            <div class="flex items-center text-[0.9vw] text-gray-600">
                {{-- Assuming average rating logic here --}}
                <span>⭐ {{ round($tree->reviews_avg_rate ?? 0, 1) }}</span>
            </div>
        </div>
    </div>
</a>