<h3 class="text-[1.4vw] font-bold text-center mb-[2vw]">
    Apakah Anda mendaur ulang sampah?
</h3>
<div class="flex flex-col gap-[1.5vw] mb-[3vw]">
    @foreach ([
        'Ya' => 0,
        'Tidak' => 24,
    ] as $label => $value)
        <div class="relative">
            <input id="op{{ $value }}" type="radio" name="household" wire:change="$refresh" wire:model="answer.{{ $step - 1 }}"
                value="{{ $value }}" class="hidden peer">
            <label for="op{{ $value }}"
                class="flex justify-center items-center w-full h-[3.5vw] rounded-[0.5vw] border border-green-2 text-green-2 text-[1.2vw] font-bold hover:bg-green-2 hover:text-white peer-checked:bg-orange-1 peer-checked:text-white peer-checked:border-none transition-colors cursor-pointer">
                {{ $label }}
            </label>
        </div>
    @endforeach
</div>


@if ($answer[8] == 0)
    <div>
        <h3 class="text-[1.4vw] font-bold text-center mb-[2vw]">
            Apa barang yang biasa Anda daur ulang?
        </h3>
        <div class="flex flex-col gap-[1.5vw] mb-[3vw]">
            @foreach ([
                'Kaca' => 'kaca',
                'Plastik' => 'plastik',
                'Kertas' => 'kertas',
                'Aluminium' => 'aluminium',
                'Besi' => 'besi',
                'Limbah makanan (pembuatan kompos)
                ' => 'makanan',
            ] as $label => $value)
                <div class="relative">
                    <input id="op{{ $value }}" type="checkbox" name="household" wire:model="recycleValue"
                        value="{{ $value }}" class="hidden peer">
                    <label for="op{{ $value }}"
                        class="flex justify-center items-center w-full h-[3.5vw] rounded-[0.5vw] border border-green-2 text-green-2 text-[1.2vw] font-bold hover:bg-green-2 hover:text-white peer-checked:bg-orange-1 peer-checked:text-white peer-checked:border-none transition-colors cursor-pointer">
                        {{ $label }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endif
