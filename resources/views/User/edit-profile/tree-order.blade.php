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

        {{-- Right Content: Tree Order --}}
        <div class="flex flex-col ml-[2vw] w-full">
            <div class="flex flex-col gap-[1.5vw]">
                @foreach ($treeOrders as $order)
                    <div class="flex flex-col gap-[1vw] bg-yellow-3 px-[3vw] py-[2vw] rounded-[1vw]">
                        <p class="text-[#7B8C7F] text-sm font-semibold">{{ $order->created_at->format('d M Y, g:i A') }}</p>
                        <div class="flex gap-[1vw]">
                            <img src="{{ asset('storage/' . $order->tree->treephoto) }}" alt="{{ $order->tree->treename }}" class="w-[7vw] h-[7vw] rounded-[0.5vw] object-cover">
                            <div class="flex justify-between w-[90%]">
                                <div class="flex flex-col gap-[0.2vw]">
                                    <p class="text-[1.5vw] font-bold">{{ $order->tree->treename }}</p>
                                    <p class="text-[#7B8C7F] text-sm">Qty: x{{ $order->amount }}</p>
                                    <p class="text-[#7B8C7F] text-sm">Organizaton: {{ $order->tree->organization->organization_name }}</p>
                                </div>

                                <div class="flex flex-col items-end">
                                    <p class="text-[1.2vw] text-orange-1 font-bold">{{ number_format($order->tree->treeprice, 0) }} pts</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
