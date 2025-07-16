<x-layout>
    <div class="flex mx-[5vw] my-[2vw]">
        @if(session('reviewSuccess'))
            <div 
                class="alert absolute z-40 flex items-center justify-center p-4 mb-4 w-[30vw] text-green-800 rounded-lg bg-green-50" 
                style="top: 10%; left: 50%; transform: translate(-50%, -50%);" 
                role="alert">
                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('reviewSuccess') }}
                </div>
                <button type="button" class="close-button ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif
        {{-- Left Sidebar: User Profile and Navigation --}}
        <x-profilebar :user="$user" />

        {{-- Right Content: User Review --}}
        <div class="flex flex-col ml-[2vw] w-full bg-yellow-3 px-[3vw] py-[2vw] rounded-[1vw] drop-shadow-md">
            <div class="flex flex-col ">
                @foreach ($reviews as $review)
                    <div class="flex flex-col items-end gap-[2vw] py-[1.5vw] border-0 border-b-1 border-b-[#7B8C7F]">
                        <div class="flex justify-between w-full">
                            <div class="flex gap-[1vw]">
                                <img src="{{ asset('storage/' . $review->product->product_images->first()->image) }}" alt="elvinson"
                                    class="w-[5vw] h-[5vw] rounded-[0.5vw] object-cover">
                                <div class="flex flex-col">
                                    <p class="text-[1.3vw] font-bold">{{ $review->product->name }}</p>
                                    
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-[0.75vw]">
                                <p>Rated at: {{ $review->created_at->format("d M Y, h:i:s A") }}</p>
                                <div>
                                    @for ($i = 0; $i < $review->rate; $i++)
                                        <i class="fa-solid fa-star text-yellow-400 text-[1.5vw]"></i>
                                    @endfor

                                    @for ($i = $review->rate; $i < 5; $i++)
                                        <i class="fa-solid fa-star text-gray-200 text-[1.5vw]"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-[0.5vw] w-[88%]">
                            <div class="text-[1vw] font-bold">
                                {{ $review->description }}
                            </div>

                            <div class="flex gap-[1vw] mt-[0.5vw]">
                                @foreach ($review->review_images as $review_image)
                                    <img src="{{ asset('storage/' . $review_image->source) }}" alt="Review Image"
                                        class="thumbnail w-[3.5vw] h-[3.5vw] rounded-[0.5vw] object-cover cursor-pointer hover:brightness-75"
                                        onclick="showImage('{{ $review->id }}', '{{ asset('storage/' . $review_image->source) }}')">
                                @endforeach
                            </div>
                            <img src="{{ asset('storage/' . $review_image->source) }}" alt="Review Image"
                                class="big-image w-[15vw] h-[15vw] rounded-[0.5vw] object-cover hidden"
                                id="{{ $review->id }}">
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="mt-[2vw]">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>

    <script>
        function showImage(review_id, source) {
            const allBigImage = document.querySelectorAll('.big-image');
            
            const selectedBigImage = document.getElementById(`${review_id}`);
            if(selectedBigImage){
                selectedBigImage.style.display = "block";
                selectedBigImage.src = `${source}`;
            }
        }   
    </script>
</x-layout>
