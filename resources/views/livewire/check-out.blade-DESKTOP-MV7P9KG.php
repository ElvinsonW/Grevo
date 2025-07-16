<div>

    <form action="/checkout" method="POST" class="mx-[5vw] my-[2vw]">
        @csrf
        @foreach ($this->selectedProductIds as $id)
            <input type="hidden" name="cartIds[]" value="{{ $id }}">
        @endforeach
        <input type="hidden" name="shippingFee" value="{{ $shippingCost }}">
        <input type="hidden" name="name" value="{{ auth()->user()->name }}">
        <input type="hidden" name="email" value="{{ auth()->user()->email }}">

        <h1 class="text-[2vw] font-bold mb-[3vw]">Check Out</h1>

        <div class="mb-[3vw]">
            <h2 class="text-[1.4vw] font-bold mb-[1.5vw]">Shopping Cart</h2>
            <div class="grid font-bold text-[1.2vw] border-b pb-[1vw] text-black gap-[1vw]"
                style="grid-template-columns: 2% 30% 15% 20% 18% 5%">
                <p></p>
                <p>Product</p>
                <p>Price</p>
                <p>Quantity</p>
                <p>Total</p>
                <p></p>
            </div>

            <div>
                @foreach ($cartProduct as $cart)
                    <div wire:key="cart-item-{{ $cart->id }}"
                        class="grid py-[1vw] items-center text-[1.2vw] font-bold font-overpass text-black gap-[1vw] border-0 border-b-1"
                        style="grid-template-columns: 2% 30% 15% 20% 18% 5%">

                        <p></p>

                        <div class="flex align-middle gap-[1.5vw]">
                            <img src="{{ asset('storage/' . $cart->product_variant->product->product_images->first()->image) }}"
                                alt="{{ $cart->product_variant->product->name }}"
                                class="w-[6vw] h-[6vw] object-cover rounded-[0.5vw]">
                            <div class="flex flex-col justify-center">
                                <h2 class="text-[1.5vw] mb-[0.3vw]">{{ $cart->product_variant->product->name }}</h2>
                                @if ($cart->product_variant->color)
                                    <p class="text-[0.8vw] mb-[0.2vw]">Color : {{ $cart->product_variant->color->name }}
                                    </p>
                                @endif

                                @if ($cart->product_variant->size)
                                    <p class="text-[0.8vw]">Size : {{ $cart->product_variant->size->name }}</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <p>Rp. {{ number_format($cart->product_variant->price) }}</p>
                        </div>

                        <div class="flex items-center gap-[1.5vw]">
                            <button type="button" wire:click="decrement({{ $cart->id }})"
                                class="w-[2.5vw] h-[2.5vw] rounded-[0.25vw] border bg-orange-1 text-white">-</button>

                            <span class="bold w-[1vw] text-center">{{ $cart->amount }}</span>

                            <button type="button" wire:click="increment({{ $cart->id }})"
                                class="w-[2.5vw] h-[2.5vw] rounded-[0.25vw] bg-green-2 text-white">+</button>
                        </div>

                        <div>
                            <p>Rp. {{ number_format($cart->product_variant->price * $cart->amount) }}</p>
                        </div>

                        <div>
                            <button type="button" wire:click="delete({{ $cart->id }})"
                                class="w-[2.5vw] h-[2.5vw] rounded-[2vw] bg-red-300">
                                <i class="fa-solid fa-trash-can text-red-500"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between">
            <div class="flex flex-col w-[62%]">
                <h2 class="text-[1.4vw] font-bold mb-[1vw]">Delivery Information</h2>
                <div class="flex flex-col gap-[1vw] bg-yellow-3 p-[2vw] rounded-[0.75vw]">
                    <div class="flex flex-col gap-[0.5vw]">
                        <p for="name" class="font-bold">Recipient name</p>
                        <p id="recipient-name" class="px-[2vw] py-[0.75vw] rounded-[0.5vw] bg-green-2 text-white w-fit text-[1.1vw]">
                            {{ $recipientName }}</p>
                    </div>

                    <div class="flex flex-col gap-[0.5vw]">
                        <label for="address" class="font-bold">Shipping Address</label>
                        <div class="relative">
                            <select wire:model="addressId" id="address" wire:change="changeAddressId($event.target.value)"
                                class="appearance-none w-[100%] px-[2vw] py-[0.75vw] rounded-[0.5vw] focus:outline-none text-[1.1vw] bg-green-2 text-white">
                                @foreach (auth()->user()->addresses as $address)
                                    <option 
                                        value="{{ $address->rajaOngkirId }}"
                                        data-recipient="{{ $address->recipient_name }}">
                                        {{ implode(
                                            ', ',
                                            array_filter([
                                                $address->street_address,
                                                $address->urban_village,
                                                $address->subdistrict,
                                                $address->city,
                                                $address->province,
                                                $address->postal_code,
                                            ]),
                                        ) }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-3 h-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-[0.5vw]">
                        <p for="price" class="font-bold">Price</p>
                        <p class="px-[2vw] py-[0.75vw] rounded-[0.5vw] bg-green-2 text-white w-fit text-[1.1vw]">Rp.
                            {{ number_format($shippingCost) }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col w-[35%]">
                <h2 class="text-[1.4vw] font-bold mb-[1vw]">Order Summary</h2>

                <div class="flex flex-col gap-[0.5vw] mb-[1vw] bg-yellow-3 p-[2vw] rounded-[0.75vw]">
                    <div class="flex justify-between w-full font-semibold">
                        <p>Subtotal</p>
                        <p>Rp. {{ number_format($this->subTotalPrice) }}</p>
                    </div>

                    <div class="flex justify-between w-full font-semibold">
                        <p>Delivery Fee</p>
                        <p>Rp. {{ number_format($shippingCost) }}</p>
                    </div>
                    <div class="border-b-2 mb-[0.75vw]"></div>

                    <div class="flex justify-between text-[1.4vw] font-bold mb-[2vw]">
                        <p>Total</p>
                        <p>Rp. {{ number_format($this->subTotalPrice + $shippingCost) }}</p>
                    </div>

                    <button type="submit"
                        class="w-full h-[3.5vw] bg-orange-1 text-white font-bold rounded-[0.5vw] cursor-pointer">Check
                        Out</button>
                </div>

            </div>
        </div>
    </form>

</div>
