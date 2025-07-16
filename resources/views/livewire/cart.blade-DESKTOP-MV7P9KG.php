<div>
    @if (session('cartSuccess'))
        
        <div 
            class="alert absolute z-40 flex items-center justify-center p-4 mb-4 w-[30vw] text-green-800 rounded-lg bg-green-50" 
            style="top: 10%; left: 50%; transform: translate(-50%, -50%);" 
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ session('cartSuccess') }}
            </div>
            <button type="button" class="close-button ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>

    @endif

    <div class="mx-[5vw] my-[2vw]">
        <h1 class="text-[2vw] font-bold mb-[3vw]">Shopping Cart</h1>

        <div class="grid font-bold text-[1.2vw] border-b border-b-[#7B8C7F] pb-[1vw] text-black gap-[1vw]"
            style="grid-template-columns: 5% 30% 15% 20% 18% 5%">
            <p></p>
            <p>Product</p>
            <p>Price</p>
            <p>Quantity</p>
            <p>Total</p>
            <p></p>
        </div>
        
        <form class="mb-[10vw]">
            @foreach ($cartProduct as $cart)
                <div wire:key="cart-item-{{ $cart->id }}" class="grid py-[1vw] items-center text-[1.2vw] font-bold font-overpass text-black gap-[1vw] border-0 border-b-1 border-b-[#7B8C7F]"
                    style="grid-template-columns: 0.5% 3.5% 30% 15% 20% 18% 5%">
                    
                    <p></p>
                    
                    <label class="mr-[1vw]">
                        <input type="checkbox"
                                wire:model="selectedProduct"
                                wire:change="$refresh"
                                value="{{ $cart->id }}" 
                                class="w-[1.5vw] h-[1.5vw] accent-green-2">
                    </label>

                    <div class="flex align-middle gap-[1.5vw]">
                        <img src="{{ asset('storage/' . $cart->product_variant->product->product_images->first()->image ) }}" 
                             alt="{{ $cart->product_variant->product->name }}" 
                             class="w-[6vw] h-[6vw] object-cover rounded-[0.5vw]">
                        <div class="flex flex-col justify-center">
                            <h2 class="text-[1.3vw] mb-[0.3vw]">{{ $cart->product_variant->product->name }}</h2>
                            @if ($cart->product_variant->color)
                                <p class="text-[0.8vw] mb-[0.2vw]">Color : {{ $cart->product_variant->color->name }}</p>
                            @endif

                            @if($cart->product_variant->size)
                                <p class="text-[0.8vw]">Size : {{ $cart->product_variant->size->name }}</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <p>Rp. {{ number_format($cart->product_variant->price) }}</p>
                    </div>

                    <div class="flex items-center gap-[1.5vw]">
                        <button type="button" 
                                wire:click="decrement({{ $cart->id }})" 
                                class="w-[2.5vw] h-[2.5vw] rounded-[0.25vw] border bg-orange-1 text-white cursor-pointer">-</button>
                        
                        <span class="bold w-[1vw] text-center">{{ $cart->amount }}</span>
                        
                        <button type="button" 
                                wire:click="increment({{ $cart->id }})" 
                                class="w-[2.5vw] h-[2.5vw] rounded-[0.25vw] bg-green-2 text-white cursor-pointer">+</button>
                    </div>

                    <div>
                        <p>Rp. {{ number_format($cart->product_variant->price * $cart->amount) }}</p>
                    </div>

                    <div>
                        <button type="button" 
                                wire:click="delete({{ $cart->id }})" 
                                class="w-[2.5vw] h-[2.5vw] rounded-[2vw] bg-red-300 cursor-pointer">
                            <i class="fa-solid fa-trash-can text-red-500"></i>
                        </button>
                    </div>
                </div>
            @endforeach
            
            <div class="fixed bottom-0 left-0 flex justify-between items-center gap-[2vw] w-full h-[7vw] px-[5vw] bg-green-1">
                <label for="selectAll" class="flex items-center justify-center gap-[1vw] text-[1.3vw] font-bold">
                    <input type="checkbox"
                            wire:model="selectAll"
                            wire:change="$refresh"
                            id="selectAll" 
                            class="w-[1.5vw] h-[1.5vw] accent-green-2">
                    <span>Select all</span> 
                </label>
                <div class="flex items-center gap-[2vw]">
                    <p class="font-bold">Total ({{ count($selectedProduct) }} items selected) : <span class="text-green-2 text-[1.5vw]">Rp. {{ number_format($this->totalPrice) }}</span></p>
                    <button type="button" 
                            wire:click="checkout" 
                            class="w-[15vw] h-[4vw] bg-orange-1 rounded-[0.5vw] text-white font-bold text-[1.5vw] cursor-pointer">
                        Checkout
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>