<x-layout>
    <div class="p-[4vw]">
        <!-- product things -->
        <div class="flex flex-wrap lg:flex-nowrap gap-10 pl-[3vw] pr-[3vw] mb-[3vw]">
            <!-- gambar + details -->
            <div class="flex flex-col w-[50%]">
                <!-- all gambar -->
                <div class="flex flex-row mb-4">
                    <!-- preview gambar di samping -->
                    <div class="flex flex-col justify-center items-center mr-6">
                        <!-- Tombol atas -->
                        <button id="prevBtn"
                            class="cursor-pointer w-[2.5vw] h-[2.5vw] bg-green-2 text-white rounded-full mb-2 flex items-center justify-center">
                            <i class="fa-solid fa-chevron-up"></i>
                        </button>

                        <!-- Container untuk N gambar -->
                        @php
                            $visibleProduct = min($product->product_images->count(), 3);
                        @endphp
                        <div class="w-[7vw] overflow-hidden rounded relative"
                            style="box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06); height: calc(7vw * {{ $visibleProduct }} + {{ $visibleProduct }}vw - 1vw);">
                            <div id="carouselImages"
                                class="flex flex-col gap-[1vw] transition-transform duration-500 ease-in-out">
                                @foreach ($product->product_images as $image) 
                                    <div class="cursor-pointer w-[7vw] h-[7vw] overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image) }}"
                                            class="preview-image w-full h-full object-cover transition-transform duration-500 hover:scale-150">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tombol bawah -->
                        <button id="nextBtn"
                            class="cursor-pointer w-[2.5vw] h-[2.5vw] bg-green-2 text-white rounded-full mt-2 flex items-center justify-center">
                            <i class="fa-solid fa-angle-down"></i>
                        </button>
                    </div>

                    <!-- main gambar -->
                    <div class="flex items-center justify-center w-[35vw] h-[35vw] relative">
                        <img src="{{ asset('storage/' . $product->product_images->first()->image) }}" id="product-big-image"
                            class="rounded-lg w-full h-full object-cover"
                            style="background-size: cover; background-position: center; box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06);">
                    </div>
                </div>


            </div>

            <!-- Right: Tab Area -->
            <form action="/cart" method="POST" class="inline-flex flex-col w-full lg:w-1/2 max-h-fit rounded-lg p-8"
                style="background-color: #FCFCF5; box-shadow: 0px 0px 12.2px 0px rgba(0,0,0,0.06);">
                @csrf
                {{-- Product Input --}}
                <input type="text" name="product_id" id="product_id" value="{{ $product->id }}" class="hidden">

                <!-- header produk -->
                <div class="flex flex-col space-y-[9px] border-b mb-5" style="border-color: #D2D2B0;">
                    <!-- nama+share -->
                    <div class="flex flex-row items-center justify-between">
                        <!-- nama produk -->
                        <h1 class="font-bold text-[#3E6137] text-[1.8vw]">{{ $product->name }}</h1>
                        <!-- share button -->
                        <div class="relative">
                            <button type="button" onclick="copyLink()" class="flex items-center gap-2 cursor-pointer">
                                <img src="{{ asset('images/share-button.svg') }}" alt="">
                                <span class="text-[1vw]">Share</span>
                            </button>

                            <p id="copyStatus"
                                class="absolute top-[3vw] right-[-2.5vw] bg-green-50 text-green-3 py-[0.75vw] w-[10vw] flex justify-center hidden">
                                Link copied!</p>
                        </div>
                    </div>

                    <div class="flex flex-row items-center justify-between mb-[8px]">
                        <!-- harga produk -->
                        <p class="text-red-600 text-lg font-bold mb-2 text-[1.2vw]">Rp
                            {{ number_format($product->product_variants->first()->price) }}</p>
                        <!-- stars -->
                        <div class="flex items-center space-x-3 text-[1vw] text-gray-600 mb-2">
                            <span class="font-bold text-green-2">⭐ {{ round($product->reviews_avg_rate, 1) }}</span>
                            <span style="color: #D2D2B0; font-size: 20px;">|</span>
                            <span>
                                <span class="font-bold text-green-2">{{ count($product->reviews) }}</span> Ratings
                            </span>
                            <span style="color: #D2D2B0; font-size: 20px;">|</span>
                            <span>
                                <span class="font-bold text-green2">{{ $product->sold }}</span> terjual
                            </span>
                        </div>
                    </div>
                </div>

                <!-- color -->
                @if ($product->product_variants->first()->color)
                    <div class="flex items-start mb-[2vw]">
                        <p class="w-[10vw] text-green-2 text-[1.2vw]" style="line-height:25px;">Warna</p>
                        <div class="flex flex-wrap gap-[1vw] text-green-2 w-[28vw]">
                            @foreach ($colors as $color)
                                <label class="items-center">
                                    <input type="radio" name="color" value="{{ $color->id }}"
                                        class="hidden peer" required>
                                    <span
                                        class="border rounded cursor-pointer  text-[1vw] px-[1vw] py-[0.25vw] flex items-center justify-center
                                        bg-yellow-2 peer-checked:bg-green-2 peer-checked:text-white transition">
                                        {{ $color->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- size -->
                @if ($product->product_variants->first()->size)
                    <div class="flex items-center mb-[2vw]">
                        <p class="w-[10vw] text-green-2 text-[1.2vw]" style="line-height:25px;">Ukuran</p>
                        <div class="flex gap-[1vw] text-green-2">
                            @foreach ($sizes as $size)
                                <label class="items-center">
                                    <input type="radio" name="size" value="{{ $size->id }}"
                                        class="hidden peer" required>
                                    <span
                                        class="border rounded cursor-pointer text-[1vw] px-[1vw] py-[0.25vw] flex items-center justify-center
                                        bg-yellow-2 peer-checked:bg-green-2 peer-checked:text-white transition">
                                        {{ $size->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- shipping -->
                <div class="flex items-center mb-8 ">
                    <p class="w-[10vw] text-green-2 text-[1.2vw]">Sertifikasi</p>
                    <p class="text-sm text-green-2 text-[1.2vw]">{{ $product->certification }}</p>
                </div>

                <!-- stock + add to cart -->
                <div class="flex items-center justify-center">
                    <div class="flex flex-col items-center justify-center mr-15">
                        <div class="flex items-center space-x-4 mb-2">
                            <button type="button"
                                class="cursor-pointer bg-yellow-2 border w-8 h-8 flex items-center justify-center rounded-full"
                                style="border-color: #D2D2B0;" id="subButton">-</button>
                            <input type="number" name="amount" class="hidden" id="amountInput" value="1">
                            <span class="bold w-[1vw] text-center" id="amountView">1</span>
                            <button type="button"
                                class="cursor-pointer bg-yellow-2 border w-8 h-8 flex items-center justify-center rounded-full"
                                style="border-color: #D2D2B0;" id="addButton">+</button>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Stock: 200</p>
                    </div>
                    <button class="cursor-pointer bg-orange-1 text-white font-bold w-[20vw] h-[3.5vw] rounded">Tambah ke Keranjang</button>
                </div>
            </form>
        </div>

        <div class="mb-[5vw]">
            <!-- product details dll -->
            <div class="mt-[2vw] w-full">
                <!-- tab -->
                <div class="flex justify-center gap-[2vw] border-b border-t border-[#D2D2B0] px-5 pt-5">
                    <!-- Product Description Tab -->
                    <div class="flex flex-col w-fit" id="details-tab">
                        <button class="cursor-pointer text-green-2 text-[1.3vw] font-semibold"
                            onclick="setActiveTab('details')">
                            Deskripsi Produk
                        </button>
                        <hr class="mt-2 border-b-2 border-green-2 rounded-full w-full" id="details-underline">
                    </div>

                    <!-- Product Material Tab -->
                    <div class="flex flex-col w-fit ml-10" id="material-tab">
                        <button class="cursor-pointer text-[#7B8C7F] text-[1.3vw] font-normal"
                            onclick="setActiveTab('material')">
                            Material Produk
                        </button>
                        <hr class="hidden mt-2 border-b-2 border-[#3E6137] rounded-full w-full"
                            id="material-underline">
                    </div>

                    <!-- Process Details Tab -->
                    <div class="flex flex-col w-fit ml-10" id="process-tab">
                        <button class="cursor-pointer text-[#7B8C7F] text-[1.3vw] font-normal"
                            onclick="setActiveTab('process')">
                            Detail Proses
                        </button>
                        <hr class="hidden mt-2 border-b-2 border-[#3E6137] rounded-full w-full"
                            id="process-underline">
                    </div>

                    <!-- Buyer Reviews Tab -->
                    <div class="flex flex-col w-fit ml-10" id="reviews-tab">
                        <button class="cursor-pointer text-[#7B8C7F] text-[1.3vw] font-normal"
                            onclick="setActiveTab('reviews')">
                            Ulasan Pembeli
                        </button>
                        <hr class="hidden mt-2 border-b-2 border-[#3E6137] rounded-full w-full"
                            id="reviews-underline">
                    </div>
                </div>

                <div class="p-5 pl-8">
                    <!-- Product Description -->
                    <div id="details-content" class="flex flex-col gap-[1vw]">
                        <div>
                            <h1 class="font-bold text-green-2 text-[1.3vw] mb-[0.5vw]">Deskripsi Produk</h1>
                            <p class="text-[1.2vw] text-gray-700">
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Product Material -->
                    <div id="material-content" class="hidden space-y-3">
                        <div>
                            <h1 class="font-bold text-green-2 text-[1.3vw] mb-[0.5vw]">Material Produk</h1>
                            <p class="text-[1.2vw] text-gray-700">
                                {{ $product->material }}
                            </p>
                        </div>
                    </div>

                    <!-- Process Details -->
                    <div id="process-content" class="hidden space-y-3">
                        <h1 class="font-bold text-green-2 text-[1.3vw]">Detail Proses</h1>
                        <p class="text-[1.2vw] text-gray-700">
                            {{ $product->process }}
                        </p>
                    </div>

                    <!-- Buyer Reviews -->
                    <div id="reviews-content" class="hidden space-y-3">
                        <h1 class="font-bold text-green-2 text-[1.3vw]">Ulasan Pembeli</h1>
                        <div class="flex flex-col">
                            @foreach ($reviews as $review)
                                <div class="flex gap-[5vw] py-[1.5vw] border-0  border-b-1 border-gray-300">
                                    <div class="flex gap-[1vw] w-[25%]">
                                        <img src="{{ asset('storage/' . $review->user->image) }}" alt="elvinson"
                                            class="w-[4vw] h-[4vw] rounded-[0.5vw] object-cover">
                                        <div class="flex flex-col">
                                            <p class="text-[1.3vw] font-bold">{{ $review->user->name }}</p>
                                            <p class="text-[0.9vw] font-bold text-orange-600">
                                                {{ $review->created_at->format('F d, Y') }}</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-[0.5vw] w-[70%]">
                                        <div>
                                            @for ($i = 0; $i < $review->rate; $i++)
                                                <i class="fa-solid fa-star text-yellow-400 text-[1.3vw]"></i>
                                            @endfor

                                            @for ($i = $review->rate; $i < 5; $i++)
                                                <i class="fa-solid fa-star text-gray-200"></i>
                                            @endfor
                                        </div>

                                        <div class="text-[1vw] font-bold">
                                            {{ $review->description }}
                                        </div>

                                        <div class="flex gap-[1vw] mt-[0.5vw]">
                                            @foreach ($review->review_images as $review_image)
                                                <img src="{{ asset('storage/' . $review_image->source) }}"
                                                    alt="Review Image"
                                                    class="w-[3.5vw] h-[3.5vw] rounded-[0.5vw] object-cover cursor-pointer hover:brightness-75"
                                                    onclick="showImage('{{ $review->id }}', '{{ asset('storage/' . $review_image->source) }}')">
                                            @endforeach
                                        </div>
                                        <img src="{{ asset('storage/' . $review_image->source) }}" alt="Review Image"
                                            class="big-image w-[15vw] h-[15vw] rounded-[0.5vw] object-cover hidden"
                                            id="{{ $review->id }}">
                                    </div>

                                </div>
                            @endforeach

                            <a href="/review/{{ $product->slug }}"
                                class="cursor-pointer hover:text-green-2 text-[1.5vw] text-center text-orange-1 font-bold mt-[2vw]">See
                                more review</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="my-[2vw] px-[5vw]">
            <!-- text -->
            <span class="flex items-center justify-center space-x-[16px] mb-10">
                <h3 class="text-[20px] font-bold text-[#3E6137]">EXPLORE</h3>
                <h1 class="text-[30px] font-bold text-[#D1764F]">PRODUK TERKAIT</h1>
            </span>

            <!-- item list -->
            <div class="flex gap-4  mx-auto justify-center">
                @foreach ($similarProducts as $similarProduct)
                    @include('components.product-card', ['product' => $similarProduct])
                @endforeach
            </div>
        </div>
    </div>
    <script>
        const carouselImages = document.getElementById('carouselImages');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        const totalImages = carouselImages.children.length;
        const visibleImages = 3; // jumlah gambar yang terlihat
        let currentIndex = 0;

        function updateCarousel() {
            // Geser sebanyak tinggi gambar * current index
            carouselImages.style.transform = `translateY(-${currentIndex * 8}vw)`;
        }

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

        if (totalImages <= visibleImages) {
            prevBtn.style.display = "none";
            nextBtn.style.display = "none";
        }

        const addButton = document.querySelector("#addButton");
        const subButton = document.querySelector("#subButton");
        const amountInput = document.querySelector("#amountInput");
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
            const tabs = ['details', 'reviews', 'process', 'material'];

            tabs.forEach(id => {
                const button = document.querySelector(`#${id}-tab button`);
                const underline = document.querySelector(`#${id}-underline`);
                if (id === tabId) {
                    button.classList.add('text-green-2', 'font-semibold');
                    button.classList.remove('text-[#7B8C7F]', 'font-normal');
                    underline.classList.remove('hidden');
                } else {
                    button.classList.add('text-green-2', 'font-normal');
                    button.classList.remove('text-[#3E6137]', 'font-semibold');
                    underline.classList.add('hidden');
                }

                // Content show/hide
                const content = document.querySelector(`#${id}-content`);
                if (id === tabId) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        }

        function showImage(review_id, source) {
            const allBigImage = document.querySelectorAll('.big-image');

            const selectedBigImage = document.getElementById(`${review_id}`);
            if (selectedBigImage) {
                selectedBigImage.style.display = "block";
                selectedBigImage.src = `${source}`;
            }
        }

        const previewImages = document.querySelectorAll("#carouselImages img");
        const productBigImage = document.querySelector("#product-big-image");

        previewImages.forEach(img => {
            img.addEventListener("click", function() {
                previewImages.forEach(i => i.classList.remove("brightness-50"));

                this.classList.add("brightness-50");

                if (productBigImage) {
                    productBigImage.src = this.src;
                }
            });
        });
    </script>
</x-layout>
