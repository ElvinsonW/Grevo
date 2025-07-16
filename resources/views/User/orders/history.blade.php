<x-layout>
    <main class="mx-auto p-6 pt-12 min-h-screen" style="background-color: #F7F6EB;">
        @if(session('cancelSuccess') || session('recievedSuccess'))
            <div 
                class="alert absolute z-40 flex items-center justify-center p-4 mb-4 w-[30vw] text-green-800 rounded-lg bg-green-50" 
                style="top: 10%; left: 50%; transform: translate(-50%, -50%);" 
                role="alert">
                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('cancelSuccess') ?? session('recievedSuccess') }}
                </div>
                <button type="button" class="close-button ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @elseif (session('cancelError'))
        
            <div class="alert absolute z-40 flex items-center p-4 mb-4 w-[30vw] text-red-800 rounded-lg bg-red-50 " 
                style="top: 10%; left: 50%; transform: translate(-50%, -50%);" 
                role="alert">
                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-[1vw] font-medium">
                    {{ session('cancelError') }}
                </div>
                <button type="button" class="close-button ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif
        
        <div class="flex mx-[5vw] gap-10">
            <!-- Left Sidebar: User Profile and Navigation -->
            @include('components.profilebar', ['user' => $user])

            <!-- Right Side: Order History -->
            <div class="flex flex-col w-full">
                <!-- search bar + filter-->
                <div class="w-full bg-[#FCFCF5] h-fit rounded-xl px-5 mb-5"
                    style="box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06);">
                    <!-- search bar -->
                    <form method="GET" action="{{ route('orders') }}"
                        class="w-full flex items-center p-4 gap-2 text-[#A6A66B]">
                        @php
                            $params = ['status'];
                        @endphp
                        @foreach ($params as $param)
                            @if (request($param))
                                <input type="hidden" value="{{ request($param) }}" name="{{ $param }}">
                            @endif
                        @endforeach
                        <input type="text" name="keyword" value="{{ request('keyword') }}"
                            placeholder="Search by Order ID or Product Name"
                            class="flex-1 border border-[#D2D2B0] rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#D2D2B0]">
                        <button type="submit" class="bg-[#D2D2B0] px-4 py-2 rounded hover:bg-[#bdbd8d] transition">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>

                    <!-- filter -->
                    <div class="flex gap-3 flex-wrap ml-6" style="margin-top: -10px;">
                        @php
                            $statuses = [
                                'all' => 'All',
                                'to-ship' => 'To Ship',
                                'to-receive' => 'To Receive',
                                'delivered' => 'Delivered',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ];
                            $active = request('status', 'all');

                            // Mapping for filtering orders by status
                            $statusMap = [
                                'to-ship' => ['ORDER PLACED'],
                                'to-receive' => ['ORDER SHIPPED'],
                                'delivered' => ['ORDER ARRIVED'],
                                'completed' => ['ORDER RECEIVED', 'ORDER COMPLETED'],
                                'cancelled' => ['CANCELLED'],
                            ];

                            $queryParams = request()->query();
                        @endphp

                        @foreach ($statuses as $key => $label)
                            @php
                                $queryParams['status'] = $key
                            @endphp
                            <a href="{{ route('orders', $queryParams) }}"
                                class="relative px-4 py-2 {{ $active === $key ? 'text-[#3E6137] font-bold' : 'text-[#D2D2B0]' }}">
                                <span class="relative z-10">{{ $label }}</span>
                                @if ($active === $key)
                                    <span class="absolute left-0 right-0 bottom-0 h-1 bg-[#3E6137] rounded"
                                        style="margin-left: -1px; margin-right: -1px;"></span>
                                @endif
                            </a>
                        @endforeach

                    </div>
                </div>

                <!-- Orders -->
                @forelse ($orders as $order)
                    <!-- order card -->
                    <div class="mb-5 rounded-xl" style="box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06);">
                        <!-- atas -->
                        <div class="w-full bg-[#FCFCF5] h-fit rounded-xl px-8 py-6 flex flex-col">
                            <!-- header -->
                            <div class="flex justify-between items-center mb-5">
                                <div class="flex flex-col gap-1">
                                    <p class="text-[#D1764F] text-sm font-bold">
                                        ORDER ID: {{ $order->order_id }}
                                    </p>
                                    <p class="text-[#7B8C7F] text-sm font-semibold">
                                        {{ \Carbon\Carbon::parse($order->statusHistories->last()->changed_at)->format('d M Y, g:i A') }}
                                    </p>
                                </div>
                                <p class="font-bold text-[#D1764F] text-xl">
                                    @php
                                        $status = $order->statusHistories->first()->status;
                                        $statusLabels = [
                                            'ORDER PLACED' => 'TO SHIP',
                                            'ORDER SHIPPED' => 'TO RECEIVE',
                                            'ORDER ARRIVED' => 'DELIVERED',
                                            'ORDER RECEIVED' => 'COMPLETED',
                                            'ORDER COMPLETED' => 'COMPLETED',
                                            'CANCELLED' => 'CANCELLED',
                                        ];
                                    @endphp
                                    <span>
                                        {{ strtoupper($statusLabels[$status] ?? $status) }}
                                    </span>
                                </p>
                            </div>

                            <a href="{{ route('order.show', $order->order_id) }}">
                                <!-- products -->
                                @foreach ($order->items as $item)
                                    <div class="flex items flex-col">
                                        <div class="flex items-center flex-row">
                                            <img src="{{ asset('storage/' . $item->variant->product->product_images->first()->image) }}" alt="{{ $item->variant->product->name }}"
                                                class="w-25 h-25 rounded-xs">
                                            <div class="ml-4 flex-1">
                                                <h2 class="text-[#3E6137] font-bold text-lg">{{ $item->variant->product->name }}</h2>
                                                <p class="text-[#7B8C7F] text-sm">Variant: {{ $item->variant->sku }}</p>
                                                <p class="text-[#7B8C7F] text-sm">{{ $item->quantity }}x</p>
                                            </div>
                                            <p class="text-[#7B8C7F] text-md font-bold">Rp
                                                {{ number_format($item->price, 0, ',', '.') }}</p>

                                        </div>
                                        @if (!$loop->last)
                                            <span class="h-[.5px] bg-[#D2D2B0] rounded my-5"
                                                style="margin-left: -1px; margin-right: -1px;"></span>
                                        @endif
                                    </div>
                                @endforeach
                            </a>
                        </div>


                        <!-- bawah -->
                        <div
                            class="flex flex-row justify-between items-center px-8 w-full bg-[#FFFFF4] h-fit rounded-xl px-8 py-6 rounded-lg">
                            <!-- button Berdasarkan Status -->
                            <div class="flex gap-4">
                                @php
                                    $status = $order->latestStatus->status;
                                @endphp

                                @if ($status === 'ORDER PLACED')
                                    <form action="/order/{{ $order->id }}/cancel" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="border border-[#7B8C7F] text-[#7B8C7F] text-sm font-semibold px-10 py-2 rounded-lg hover:bg-[#fef5f1] transition">
                                            Cancel Order
                                        </button>
                                    </form>
                                @elseif ($status === 'ORDER ARRIVED')
                                    <form action="/order/{{ $order->id }}/receive" method="POST">
                                        @csrf

                                        <button type="submit"
                                            class="bg-[#3E6137] text-[#FCFCF5] text-sm font-semibold px-10 py-2 rounded-lg hover:bg-[#68806f] transition">
                                            Order Received
                                        </button>
                                    </form>
                                @elseif ($status === 'ORDER RECEIVED')
                                    <a href="/products"
                                        class="bg-[#3E6137] text-[#FCFCF5] text-sm font-semibold px-10 py-2 rounded-lg hover:bg-[#68806f] transition">
                                        Buy Again
                                    </a>
                                    <a href="/review/{{ $order->id }}/create"
                                        class="border border-[#7B8C7F] text-[#7B8C7F] text-sm font-semibold px-10 py-2 rounded-lg hover:bg-[#f0f5f2] transition">
                                        Rate
                                    </a>
                                @elseif ($status === 'ORDER COMPLETED')
                                    <a href=""
                                        class="bg-[#3E6137] text-[#FCFCF5] text-sm font-semibold px-10 py-2 rounded-lg hover:bg-[#68806f] transition">
                                        Buy Again
                                    </a>
                                @elseif ($status === 'CANCELLED')
                                    <a href="/products"
                                        class="bg-[#3E6137] text-[#FCFCF5] text-sm font-semibold px-10 py-2 rounded-lg hover:bg-[#68806f] transition">
                                        Buy Again
                                    </a>
                                @endif
                            </div>

                            <!-- 💰 Total -->
                            <div class="flex flex-row items-center gap-10 text-right">
                                <p class="text-sm font-semibold text-[#7B8C7F]">Order total:</p>
                                @php
                                    $merchandise = $order->items->sum(fn($item) => $item->price * $item->quantity);
                                    $total = $merchandise + $order->shipping;
                                @endphp

                                <p class="text-xl font-bold text-[#D1764F]">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </p>

                            </div>
                        </div>
                    </div>

                @empty
                    <img src="{{ asset('images/noorders.svg') }}" alt="No Orders" class="h-50 w-auto mt-30">

                @endforelse

            </div>
        </div>
        </div>
</x-layout>
