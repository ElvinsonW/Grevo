<div class="px-[5vw] my-[2vw]">
    @if ($step == 1)
        <h1 class="font-bold text-[2vw] mb-[1.5vw]">Select Product</h1>
        <div class="flex flex-wrap justify-between gap-[1.5vw] mb-[2vw]">
            @foreach ($product_variants as $variant)
                <button type="button"
                    class="flex items-center gap-[1vw] bg-yellow-3 w-[49%] px-[2vw] py-[1vw] rounded-[0.75vw] transition-colors duration-300 {{ in_array($variant->product->id, $reviewedProducts) ? 'opacity-50 cursor-none' : 'hover:bg-green-2 hover:text-white cursor-pointer' }}"
                    wire:click="goReview({{ $variant->id }})" wire:key="variant-{{ $variant->id }}"
                    {{ in_array($variant->product->id, $reviewedProducts) ? 'disabled' : '' }}>
                    <img src="{{ asset('storage/' . $variant->product->product_images->first()->image) }}"
                        alt="{{ $variant->product->name }}" class="w-[5vw] h-[5vw] object-cover rounded-[0.5vw]">
                    <h2 class="font-bold text-[1.5vw]">{{ $variant->product->name }}</h2>
                </button>
            @endforeach
        </div>

        @if ($this->endError)
            <p class="text-red-600 text-[1.3vw] font-bold mb-[2vw]">{{ $this->endError }}</p>
        @endif


        <button wire:click="endReview"
            class="bg-green-2 w-fit px-[3vw] py-[1vw] font-bold text-white text-[1.3vw] rounded-[0.5vw]">
            End Review
        </button>
    @else
        <h1 class="text-[2vw] font-bold mb-[2vw]">Review Product</h1>
        <div class="flex items-center gap-[0.5vw] mb-[2vw]">
            <img src="{{ asset('storage/' . $selectedProduct->product_images->first()->image) }}"
                alt="{{ $selectedProduct->name }}" class="w-[5vw] h-[5vw] object-cover rounded-[0.5vw]">
            <h2 class="font-bold text-[1.5vw]">{{ $selectedProduct->name }}</h2>
        </div>
        <form action="/review" method="POST" enctype="multipart/form-data" class="flex flex-col gap-[2vw]">
            @csrf

            <div class="flex flex-col gap-[1vw]">
                <label for="rate" class="text-[1.2vw] font-bold">Rate</label>
                <div class="flex gap-[0.5vw] cursor-pointer">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star text-[2vw] cursor-pointer {{ $rate >= $i ? 'text-yellow-400' : 'text-gray-200' }}"
                            wire:click="$set('rate', {{ $i }})">
                        </i>
                    @endfor
                </div>

                @error('rate')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex flex-col gap-[1vw]">
                <label for="description" class="text-[1.2vw] font-bold">Description</label>
                <textarea wire:model="desc" id="desc" rows="3"
                    class="rounded-[0.5vw] p-[1vw] focus:outline-none border text-[1.2vw]"></textarea>
                @error('description')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex flex-col gap-[1vw]">
                <label for="images" class="text-[1.2vw] font-bold">Review Image</label>
                <label for="images"
                    class="cursor-pointer w-fit px-[2vw] py-[0.75vw] rounded-[0.5vw] bg-green-2 text-[1.1vw] text-white font-bold mb-[0.5vw]">Add
                    Review Image +</label>
                <input id="images" wire:model="imagesUpload" type="file" class="hidden mb-[1vw]" multiple />
                <div class="flex flex-wrap gap-[1vw]">
                    @if ($images)
                        @foreach ($images as $key => $image)
                            <div class="relative w-[10vw] h-[10vw]">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                    class="w-full h-full rounded-[1vw] object-cover border">
                                <button type="button" wire:click="removeImage({{ $key }})"
                                    class="absolute top-[0.2vw] right-[0.2vw] bg-red-500 text-white w-[1.5vw] h-[1.5vw] rounded-full text-center leading-[1.5vw] text-[1vw]">×</button>
                            </div>
                        @endforeach
                    @endif
                </div>


                @error('image')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="button"
                class="cursor-pointer w-fit px-[2vw] py-[0.5vw] rounded-[0.5vw] bg-orange-1 text-white font-bold"
                wire:click="saveReview">
                Submit
            </button>
        </form>
    @endif


</div>
