<h3 class="text-[1.4vw] font-bold text-center mb-[2vw]">
    Seberapa jauh Anda bepergian menggunakan kendaraan pribadi setiap tahun?
</h3>
<div class="flex flex-col gap-[1.5vw] mb-[3vw]">
    @foreach ([
        'Lebih dari 65 km' => 12,
        '40 km sampai 65 km' => 10,
        '4 km sampai 40 km' => 6,
        'Kurang dari 4 km' => 4,
        "Saya tidak punya atau menggunakan kendaraan pribadi" => 0,
    ] as $label => $value)
        <div class="relative">
            <input id="op{{ $value }}" type="radio" name="household" wire:model="answer.{{ $step - 1 }}"
                value="{{ $value }}" class="hidden peer">
            <label for="op{{ $value }}"
                class="flex justify-center items-center w-full h-[3.5vw] rounded-[0.5vw] border border-green-2 text-green-2 text-[1.2vw] font-bold hover:bg-green-2 hover:text-white peer-checked:bg-orange-1 peer-checked:text-white peer-checked:border-none transition-colors cursor-pointer">
                {{ $label }}
            </label>
        </div>
    @endforeach
</div>
