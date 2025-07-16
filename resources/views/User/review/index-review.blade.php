<x-layout>
    <div class="mx-[5vw] my-[2vw]">
        <h1 class="text-[2vw] font-bold mb-[1.5vw]">Product Review</h1>
        <div class="flex items-center h-fit pb-[1.5vw] border-0 border-b-1 border-b-gray-300">
            <div class="h-[9vw] flex flex-col justify-center border-0 border-r-2 border-r-gray-300 pr-[3vw]">
                <h2 class="text-[1.3vw] font-bold">Total Reviews</h2>
                <h3 class="text-[2.5vw] font-bold">
                    {{ $totalReview }}
                </h3>
                <p class="text-[1vw] font-bold text-gray-400">Product : {{ $reviews->first()->product->name }}</p>
            </div>

            <div class="h-[9vw] flex flex-col justify-center border-0 border-r-2 border-r-gray-300 px-[3vw]">
                <h2 class="text-[1.3vw] font-bold">Average Ratings</h2>
                <div class="flex gap-[1vw] items-center">
                    <h3 class="text-[2.5vw] font-bold">{{ $avgRate }}</h3>
                    @php
                        $roundedAvgRate = floor($avgRate);
                    @endphp
                    <div class="flex gap-[0.25vw]">
                        @for ($i = 0 ; $i < $roundedAvgRate ; $i++)
                            <i class="fa-solid fa-star text-yellow-400 text-[1.3vw]"></i>
                        @endfor
                        
                        <div class="relative w-[1.3vw]">
                            <i class="absolute fa-solid fa-star text-gray-200 text-[1.3vw]"></i>
                            <i class="absolute fa-solid fa-star-half text-yellow-400 text-[1.3vw]"></i>
                        </div>

                        @for ($i = $roundedAvgRate ; $i < 4 ; $i++)
                            <i class="fa-solid fa-star text-gray-200 text-[1.3vw]"></i>
                        @endfor
                    </div>
                </div>
                <p class="text-[1vw] font-bold text-gray-400">Product : {{ $reviews->first()->product->name }}</p>
            </div>

            <div class="flex flex-col px-[3vw]">
                @php
                    $fiveStar = $reviews->where('rate', 5)->count();
                    $fourStar = $reviews->where('rate', 4)->count();
                    $threeStar = $reviews->where('rate', 3)->count();
                    $twoStar = $reviews->where('rate', 2)->count();
                    $oneStar = $reviews->where('rate', 1)->count();
                @endphp
                <div class="flex items-center gap-[1vw]">
                    <div class="flex gap-[0.25vw] items-center w-[2vw]">
                        <i class="fa-solid fa-star text-[1vw] text-yellow-400"></i>
                        <p class="font-bold text-[1.1vw]">5</p>
                    </div>

                    <div class="w-[15vw] h-[0.9vw] rounded-[10vw] bg-gray-300">
                        <div class="h-full rounded-[10vw] bg-green-2" style="width: {{ $fiveStar/$totalReview * 100 }}%;"></div>
                    </div>

                    <div class="font-bold text-[1.1vw]">{{ $fiveStar }}</div>
                </div>
                <div class="flex items-center gap-[1vw]">
                    <div class="flex gap-[0.25vw] items-center w-[2vw]">
                        <i class="fa-solid fa-star text-[1vw] text-yellow-400"></i>
                        <p class="font-bold text-[1.1vw]">4</p>
                    </div>

                    <div class="w-[15vw] h-[0.9vw] rounded-[10vw] bg-gray-300">
                        <div class="h-full rounded-[10vw] bg-green-2" style="width: {{ $fourStar/$totalReview * 100 }}%;"></div>
                    </div>

                    <div class="font-bold text-[1.1vw]">{{ $fourStar }}</div>
                </div>
                <div class="flex items-center gap-[1vw]">
                    <div class="flex gap-[0.25vw] items-center w-[2vw]">
                        <i class="fa-solid fa-star text-[1vw] text-yellow-400"></i>
                        <p class="font-bold text-[1.1vw]">3</p>
                    </div>

                    <div class="w-[15vw] h-[0.9vw] rounded-[10vw] bg-gray-300">
                        <div class="h-full rounded-[10vw] bg-green-2" style="width: {{ $threeStar/$totalReview * 100 }}%;"></div>
                    </div>

                    <div class="font-bold text-[1.1vw]">{{ $threeStar }}</div>
                </div>
                <div class="flex items-center gap-[1vw]">
                    <div class="flex gap-[0.25vw] items-center w-[2vw]">
                        <i class="fa-solid fa-star text-[1vw] text-yellow-400"></i>
                        <p class="font-bold text-[1.1vw]">2</p>
                    </div>

                    <div class="w-[15vw] h-[0.9vw] rounded-[10vw] bg-gray-300">
                        <div class="h-full rounded-[10vw] bg-green-2" style="width: {{ $twoStar/$totalReview * 100 }}%;"></div>
                    </div>

                    <div class="font-bold text-[1.1vw]">{{ $twoStar }}</div>
                </div>
                <div class="flex items-center gap-[1vw]">
                    <div class="flex gap-[0.25vw] items-center w-[2vw]">
                        <i class="fa-solid fa-star text-[1vw] text-yellow-400"></i>
                        <p class="font-bold text-[1.1vw]">1</p>
                    </div>

                    <div class="w-[15vw] h-[0.9vw] rounded-[10vw] bg-gray-300">
                        <div class="h-full rounded-[10vw] bg-green-2" style="width: {{ $oneStar/$totalReview * 100 }}%;"></div>
                    </div>

                    <div class="font-bold text-[1.1vw]">{{ $oneStar }}</div>
                </div>

            </div>
        </div>

        <div class="flex flex-col ">
            @foreach ($reviews as $review)
                <div class="flex gap-[5vw] px-[2vw] py-[1.5vw] border-0  border-b-1 border-gray-300">
                    <div class="flex gap-[1vw] w-[25%]">
                        <img src="{{ asset('storage/' . $review->user->image) }}" alt="elvinson" class="w-[4vw] h-[4vw] rounded-[0.5vw] object-cover">
                        <div class="flex flex-col">
                            <p class="text-[1.3vw] font-bold">{{ $review->user->name }}</p>
                            <p class="text-[0.9vw] font-bold text-orange-600">{{ $review->created_at->format("F d, Y") }}</p>
                        </div>
                    </div>
                
                    <div class="flex flex-col gap-[0.5vw] w-[70%]">
                        <div>
                            @for ($i = 0 ; $i < $review->rate ; $i++)
                                <i class="fa-solid fa-star text-yellow-400 text-[1.3vw]"></i>
                            @endfor

                            @for ($i = $review->rate ; $i < 5 ; $i++)
                                <i class="fa-solid fa-star text-gray-200"></i>
                            @endfor
                        </div>

                        <div class="text-[1vw] font-bold">
                           {{ $review->description }}
                        </div>

                        <div class="flex gap-[1vw] mt-[0.5vw]">
                            @foreach ($review->review_images as $review_image)
                                <img 
                                    src="{{ asset('storage/' . $review_image->source) }}" 
                                    alt="Review Image" 
                                    class="thumbnail w-[3.5vw] h-[3.5vw] rounded-[0.5vw] object-cover cursor-pointer hover:brightness-75"
                                    onclick="showImage('{{ $review->id }}', '{{ asset('storage/' . $review_image->source) }}')">
                            @endforeach
                        </div>
                        <img 
                            src="{{ asset('storage/' . $review_image->source) }}" 
                            alt="Review Image" 
                            class="big-image w-[15vw] h-[15vw] rounded-[0.5vw] object-cover hidden" 
                            id="{{ $review->id }}">                        
                    </div>
                    
                </div>
            @endforeach
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
