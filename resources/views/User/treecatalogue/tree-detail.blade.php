<x-layout>
    <div class="p-[4vw]">
        <div class="flex flex-wrap lg:flex-nowrap gap-10 pl-[3vw] pr-[3vw] mb-[3vw]">
            <div class="flex flex-col w-[50%]">
                <div class="flex flex-row mb-4">
                    <div class="flex flex-col justify-center items-center mr-6">
                        <button id="prevBtn"
                            class="cursor-pointer w-[2.5vw] h-[2.5vw] bg-green-2 text-white rounded-full mb-2 flex items-center justify-center">
                            <i class="fa-solid fa-chevron-up"></i>
                        </button>

                        @php
                            $treeImages = [asset('storage/' . $tree->treephoto)]; // Array for carousel
                            // $treeImages[] = asset('images/tree_alt_1.png');
                            // $treeImages[] = asset('images/tree_alt_2.png');

                            $visibleImages = min(count($treeImages), 3);
                        @endphp
                        <div class="w-[7vw] overflow-hidden rounded relative"
                            style="box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06); height: calc(7vw * {{ $visibleImages }} + {{ $visibleImages }}vw - 1vw);">
                            <div id="carouselImages"
                                class="flex flex-col gap-[1vw] transition-transform duration-500 ease-in-out">
                                @foreach($treeImages as $image)
                                        <div class="cursor-pointer w-[7vw] h-[7vw] overflow-hidden">
                                            <img src="{{ $image }}"
                                                class="preview-image w-full h-full object-cover transition-transform duration-500 hover:scale-150">
                                        </div>
                                @endforeach
                            </div>
                        </div>

                        <button id="nextBtn"
                            class="cursor-pointer w-[2.5vw] h-[2.5vw] bg-green-2 text-white rounded-full mt-2 flex items-center justify-center">
                            <i class="fa-solid fa-angle-down"></i>
                        </button>
                    </div>

                    <div class="flex items-center justify-center w-[35vw] h-[35vw] relative">
                        <img src="{{ asset('storage/' . $tree->treephoto) }}" id="product-big-image"
                            class="rounded-lg w-full h-full object-cover"
                            style="background-size: cover; background-position: center; box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06);">
                    </div>
                </div>
            </div>

            {{-- PERBAIKAN DI SINI: method="POST" dan action="/tree-orders" --}}
            <form action="/tree-orders" method="POST" class="inline-flex flex-col w-full lg:w-1/2 max-h-fit rounded-lg p-8"
                style="background-color: #FCFCF5; box-shadow: 0px 0px 12.2px 0px rgba(0,0,0,0.06);">
                @csrf
                <input type="hidden" name="tree_id" id="tree_id" value="{{ $tree->treeid }}">
                <input type="hidden" name="amount" id="amountInput" value="1"> {{-- amount input hidden --}}

                <div class="flex flex-col space-y-[9px] border-b mb-5" style="border-color: #D2D2B0;">
                    <div class="flex flex-row items-center justify-between">
                        <h1 class="font-bold text-[#3E6137] text-[1.8vw]">{{ $tree->treename }}</h1>
                        <div class="relative">
                            <button onclick="copyLink()" type="button" class="flex items-center gap-2 cursor-pointer">
                                <img src="{{ asset('images/share-button.svg') }}" alt="">
                                <span class="text-[1vw]">Share</span>
                            </button>

                            <p id="copyStatus"
                                class="absolute top-[3vw] right-[-2.5vw] bg-green-50 text-green-3 py-[0.75vw] w-[10vw] flex justify-center hidden">
                                Link copied!</p>
                        </div>
                    </div>

                    <div class="flex flex-row items-center justify-between mb-[8px]">
                        <p class="text-red-600 text-lg font-bold mb-2 text-[1.2vw]">Rp
                            {{ number_format($tree->treeprice) }}</p>
                    </div>
                </div>

                <div class="flex items-center mb-8 ">
                    <p class="w-[10vw] text-green-2 text-[1.2vw]">Life Expectancy</p>
                    <p class="text-sm text-green-2 text-[1.2vw]">{{ $tree->treelife }} years</p>
                </div>

                <div class="flex items-center justify-center">
                    <div class="flex flex-col items-center justify-center mr-15">
                        <div class="flex items-center space-x-4 mb-2">
                            <button type="button"
                                class="cursor-pointer bg-yellow-2 border w-8 h-8 flex items-center justify-center rounded-full"
                                style="border-color: #D2D2B0;" id="subButton">-</button>
                            <span class="bold w-[1vw] text-center" id="amountView">1</span>
                            <button type="button"
                                class="cursor-pointer bg-yellow-2 border w-8 h-8 flex items-center justify-center rounded-full"
                                style="border-color: #D2D2B0;" id="addButton">+</button>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Available: Many</p>
                    </div>
                    <button type="submit" class="cursor-pointer bg-orange-1 text-white font-bold w-[20vw] h-[3.5vw] rounded">ADOPT TREE</button>
                </div>
            </form>
        </div>

        <div class="mb-[5vw]">
            <div class="mt-[2vw] w-full">
                <div class="flex justify-center gap-[2vw] border-b border-t border-[#D2D2B0] px-5 pt-5">
                    <div class="flex flex-col w-fit" id="details-tab">
                        <button class="cursor-pointer text-green-2 text-[1.3vw] font-semibold"
                            onclick="setActiveTab('details')">
                            Tree Description
                        </button>
                        <hr class="mt-2 border-b-2 border-green-2 rounded-full w-full" id="details-underline">
                    </div>

                    <div class="flex flex-col w-fit ml-10" id="material-tab">
                        <button class="cursor-pointer text-[#7B8C7F] text-[1.3vw] font-normal"
                            onclick="setActiveTab('material')">
                            Tree Care
                        </button>
                        <hr class="hidden mt-2 border-b-2 border-[#3E6137] rounded-full w-full"
                            id="material-underline">
                    </div>

                    <div class="flex flex-col w-fit ml-10" id="process-tab">
                        <button class="cursor-pointer text-[#7B8C7F] text-[1.3vw] font-normal"
                            onclick="setActiveTab('process')">
                            Organization Details
                        </button>
                        <hr class="hidden mt-2 border-b-2 border-[#3E6137] rounded-full w-full"
                            id="process-underline">
                    </div>
                </div>

                <div class="p-5 pl-8">
                    <div id="details-content" class="flex flex-col gap-[1vw]">
                        <div>
                            <h1 class="font-bold text-green-2 text-[1.3vw] mb-[0.5vw]">Tree Description</h1>
                            <p class="text-[1.2vw] text-gray-700">
                                {{ $tree->treedesc }}
                            </p>
                        </div>
                    </div>

                    <div id="material-content" class="hidden space-y-3">
                        <div>
                            <h1 class="font-bold text-green-2 text-[1.3vw] mb-[0.5vw]">Tree Care</h1>
                            <p class="text-[1.2vw] text-gray-700">
                                {{ $tree->treecare ?? 'Information about tree care will be available here.' }}
                            </p>
                        </div>
                    </div>

                    <div id="process-content" class="hidden space-y-3">
                        <h1 class="font-bold text-green-2 text-[1.3vw]">Organization Details</h1>
                        <p class="text-[1.2vw] text-gray-700">
                            @if ($tree->organization)
                                <strong>Organization Name:</strong> {{ $tree->organization->organization_name }}<br>
                                <strong>Address:</strong> {{ $tree->organization->operational_address }}<br>
                                <strong>Description:</strong> {{ $tree->organization->brief_description }}<br>
                                <strong>Contact:</strong> {{ $tree->organization->official_contact_info }}
                            @else
                                No organization details available for this tree.
                            @endif
                        </p>
                        {{-- ADD THIS "SEE DETAILS" BUTTON --}}
                        @if ($tree->organization)
                            <a href="{{ route('treecatalogue.organization-detail', ['organizationName' => $tree->organization->organization_name]) }}"
                               class="inline-block bg-orange-1 text-white font-bold px-4 py-2 rounded mt-4 hover:bg-orange-2 transition-colors duration-200">
                                See Details
                            </a>
                        @endif
                    </div>

                    {{-- Removed Buyer Reviews Content --}}
                </div>
            </div>
        </div>

        <div class="my-[2vw] px-[5vw]">
            <span class="flex items-center justify-center space-x-[16px] mb-10">
                <h1 class="text-[30px] font-bold text-[#3E6137]">TREE BATCHES</h1>
            </span>

            <div class="flex gap-4 mx-auto justify-center">
                @forelse ($treeBatches as $batch)
                    {{-- Assuming $batch has properties like batch_name, description, etc. --}}
                    <div class="flex flex-col w-[20vw] h-[26vw] rounded-[1vw] overflow-hidden" style="box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06);">
                        {{-- Placeholder for batch image, if any --}}
                        <div class="w-full h-[15vw] bg-gray-200 flex items-center justify-center">
                            {{-- <img src="{{ asset('storage/' . $batch->image) }}" alt="{{ $batch->name }}" class="w-full h-full object-cover"> --}}
                            <span class="text-gray-500 text-[1.5vw]">BATCH IMAGE</span>
                        </div>
                        <div class="p-[1vw] flex flex-col justify-between flex-grow">
                            <h3 class="font-bold text-[#3E6137] text-[1.2vw] mb-[0.5vw]">
                                @if($loop->first) (newest) @endif {{ $batch->batch_name }}
                            </h3>
                            <p class="text-gray-600 text-[0.9vw] line-clamp-2 mb-[1vw]">{{ $batch->description }}</p>
                            {{-- You can add batch-specific details here, e.g., planting date --}}
                            <p class="text-gray-500 text-[0.8vw]">Planting Date: {{ $batch->planting_date->format('F d, Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-[1.2vw] text-gray-700">No tree batches found.</p>
                @endforelse
            </div>
        </div>
    </div>
    @if (session('success'))
        <div 
            class="alert absolute z-40 flex items-center justify-center p-4 mb-4 w-[30vw] text-green-800 rounded-lg bg-green-50" 
            style="top: 10%; left: 50%; transform: translate(-50%, -50%);" 
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button type="button" class="close-button ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert absolute z-40 flex items-center p-4 mb-4 w-[30vw] text-red-800 rounded-lg bg-red-50 " 
            style="top: 10%; left: 50%; transform: translate(-50%, -50%);" 
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-[1vw] font-medium">
                {{ session('error') }}
            </div>
            <button type="button" class="close-button ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-2" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif
    <script>
        const carouselImages = document.getElementById('carouselImages');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        const totalImages = carouselImages.children.length;
        const visibleImages = 3; // jumlah gambar yang terlihat
        let currentIndex = 0;

        // Only enable buttons if there are more images than visibleImages
        if (totalImages <= visibleImages) {
            prevBtn.style.display = "none";
            nextBtn.style.display = "none";
        } else {
            prevBtn.addEventListener('click', () => {
                if (currentIndex > 0) {
                    currentIndex -= 1; // geser 1 gambar ke atas
                    updateCarousel();
                }
            });

            nextBtn.addEventListener('click', () => {
                if (currentIndex < totalImages - visibleImages) {
                    currentIndex += 1; // geser 1 gambar ke bawah
                    updateCarousel();
                }
            });
        }

        function updateCarousel() {
            // Geser sebanyak tinggi gambar * current index
            carouselImages.style.transform = `translateY(-${currentIndex * 8}vw)`;
        }


        const addButton = document.querySelector("#addButton");
        const subButton = document.querySelector("#subButton");
        const amountInput = document.querySelector("#amountInput"); // Ini sekarang hidden input
        const amountView = document.querySelector("#amountView");

        addButton.onclick = function() {
            let currentValue = parseInt(amountInput.value);
            amountInput.value = currentValue + 1;
            amountView.textContent = amountInput.value;
        };

        subButton.onclick = function() {
            let currentValue = parseInt(amountInput.value);
            if (currentValue > 1) {
                amountInput.value = currentValue - 1;
                amountView.textContent = amountInput.value;
            }
        };

        function copyLink() {
            const url = window.location.href;

            navigator.clipboard.writeText(url).then(() => {
                const status = document.getElementById('copyStatus');
                status.classList.remove('hidden');
                status.textContent = 'Link copied!';

                setTimeout(() => {
                    status.classList.add('hidden');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        function setActiveTab(tabId) {
            const tabs = ['details', 'material', 'process']; // Updated tab IDs, removed 'reviews'

            tabs.forEach(id => {
                const button = document.querySelector(`#${id}-tab button`);
                const underline = document.querySelector(`#${id}-underline`);
                const content = document.querySelector(`#${id}-content`);

                if (id === tabId) {
                    button.classList.add('text-green-2', 'font-semibold');
                    button.classList.remove('text-[#7B8C7F]', 'font-normal');
                    underline.classList.remove('hidden');
                    content.classList.remove('hidden');
                } else {
                    button.classList.add('text-[#7B8C7F]', 'font-normal');
                    button.classList.remove('text-green-2', 'font-semibold');
                    underline.classList.add('hidden');
                    content.classList.add('hidden');
                }
            });
        }

        // Removed showImage function as review images section is removed.

        const previewImages = document.querySelectorAll("#carouselImages img");
        const productBigImage = document.querySelector("#product-big-image");

        previewImages.forEach(img => {
            img.addEventListener("click", function() {
                // Remove brightness from all preview images
                previewImages.forEach(i => i.classList.remove("brightness-50"));

                // Add brightness to the clicked image
                this.classList.add("brightness-50");

                // Update the main product image
                if (productBigImage) {
                    productBigImage.src = this.src;
                }
            });
        });
    </script>
</x-layout>