<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    @vite('resources/css/app.css')
</head>
<body class="p-4 bg-yellow-2">
    @include('components.sidebar')

<div class="w-[93vw] p-6">
    <h1 class="text-4xl font-bold mb-4 ml-[5vw]">Product List</h1>
    <div class="flex flex-row justify-between mb-4 ml-[5vw]">
        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.orders.index') }}">
            @php
                $selectedStatus = request('status', 'new');
            @endphp
            <select name="status" onchange="this.form.submit()" class="border rounded px-3 py-1">
                @foreach (['new' => 'New', 'shipping' => 'Shipping', 'arrived' => 'Arrived', 'done' => 'Done', 'cancelled' => 'Cancelled'] as $key => $label)
                    <option value="{{ $key }}" {{ $selectedStatus === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>



    {{-- Products Table --}}
    <div class="bg-white rounded shadow ml-[5vw]">
        <table class="min-w-full text-sm">
            <thead class="bg-green-100 text-left">
                <tr>
                    <th class="px-4 py-3">Order ID</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Order Items</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Total Price</th>
                </tr>
            </thead>
            <tbody class="bg-yellow-2">
                @foreach ($orders as $order)
                    @php
                        $merchandise = $order->items->sum(fn($item) => $item->price * $item->quantity);
                        $total = $merchandise + $order->shipping;
                        $status = $order->latestStatus;

                        $rawStatus = $order->latestStatus->status ?? 'ORDER PLACED';

                        $statusMap = [
                            'New' => 'ORDER PLACED',
                            'Shipping' => 'ORDER SHIPPED',
                            'Arrived' => 'ORDER ARRIVED',
                            'Done' => ['ORDER RECEIVED', 'ORDER COMPLETED'],
                            'Cancelled' => 'ORDER CANCELLED',
                        ];

                        $statusFlow = [
                            'New' => ['Shipping', 'Cancelled'],
                            'Shipping' => ['Arrived'],
                            'Arrived' => ['Done'],
                            'Done' => [],
                            'Cancelled' => [],
                        ];

                        $currentDisplay = collect($statusMap)->filter(function ($dbStatus) use ($rawStatus) {
                            return is_array($dbStatus)
                                ? in_array($rawStatus, $dbStatus)
                                : $dbStatus === $rawStatus;
                        })->keys()->first() ?? 'New';

                        $nextOptions = $statusFlow[$currentDisplay] ?? [];

                    @endphp
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $order->order_id }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($status->changed_at)->format('M d, Y') }}</td>
                        <td class="px-4 py-3">{{ $order->user->username }}</td>
                        <!-- order items -->
                        <td class="px-4 py-3"> 
                            <!-- Button to open modal -->
                            <button 
                                type="button" 
                                class="bg-green-100 px-3 py-1 rounded hover:bg-[#3E6137] hover:text-white" 
                                onclick="document.getElementById('order-items-modal-{{ $order->id }}').classList.remove('hidden')"
                            >
                                Items
                            </button>

                            <!-- Modal -->
                            <div 
                                id="order-items-modal-{{ $order->id }}" 
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 hidden"
                                style="backdrop-filter: blur(2px);"
                                onclick="if(event.target === this) document.getElementById('order-items-modal-{{ $order->id }}').classList.add('hidden')"
                            >
                                <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative" onclick="event.stopPropagation();">
                                    <!-- Close button -->
                                    <button 
                                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl"
                                        onclick="document.getElementById('order-items-modal-{{ $order->id }}').classList.add('hidden')"
                                    >&times;</button>
                                    <h2 class="text-xl font-bold mb-4">Order Items</h2>
                                    @foreach ($order->items as $item)
                                        <div class="flex flex-col">
                                            <div class="flex items-center flex-row">
                                                <img src="{{ asset('storage/' . $item->img) }}" alt="{{ $item->name }}" class="w-24 h-24 rounded-xs object-cover">
                                                <div class="ml-4 flex-1">
                                                    <h2 class="text-[#3E6137] font-bold text-lg">{{ $item->name }}</h2>
                                                    <p class="text-[#7B8C7F] text-sm">Variant: {{ $item->varname }}</p>
                                                    <p class="text-[#7B8C7F] text-sm">{{ $item->quantity }}x</p>
                                                </div>
                                                <p class="text-[#7B8C7F] text-md font-bold">Rp {{ number_format($item->price*$item->quantity, 0, ',', '.') }}</p>
                                            </div>
                                            @if (!$loop->last)
                                                <span class="h-[.5px] bg-[#D2D2B0] rounded my-5 block" style="margin-left: -1px; margin-right: -1px;"></span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </td>
                        <!-- status -->
                        <td class="px-4 py-3">
                            @if (empty($nextOptions) || $currentDisplay === 'Arrived')
                                <span class="px-2 py-1 rounded text-sm font-semibold text-gray-700 bg-[#B9D5FF]">
                                    {{ $currentDisplay }}
                                </span>
                            @else
                                <form method="POST" action="{{ route('admin.orders.storeStatusHistory', $order->id) }}">
                                    @csrf
                                    <select name="status" class="border rounded px-2 py-1 bg-[#B9D5FF]" onchange="this.form.submit()">
                                        <option selected disabled>{{ $currentDisplay }}</option>
                                        @foreach ($nextOptions as $next)
                                            @php
                                                $dbStatus = is_array($statusMap[$next]) ? $statusMap[$next][0] : $statusMap[$next];
                                            @endphp
                                            <option value="{{ $dbStatus }}">{{ $next }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            @endif

                        </td>
                        <td class="px-4 py-3">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                @if ($orders->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center px-4 py-6 text-gray-500">No product orders found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 ml-[5vw]">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
</body>
</html>
