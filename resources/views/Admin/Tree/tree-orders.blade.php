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


    <div class="w-[93vw] p-15 ml-5 mt-5">
        <div class="flex flex-row justify-between items-center mb-4 ml-[5vw]">
            <h1 class="text-4xl font-bold">Tree Order List</h1>
        </div>

        <div class="bg-white rounded shadow ml-[5vw]">
            <table class="min-w-full text-sm">
                <thead class="bg-green-100 text-left">
                    <tr>
                        <th class="px-4 py-3">Order ID</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Item Name</th>
                        <th class="px-4 py-3">Organization</th>
                        <th class="px-4 py-3">Qty</th>
                        <th class="px-4 py-3">Total</th>
                    </tr>
                </thead>
                <tbody class ="bg-yellow-2">
                    @foreach ($treeorders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">#{{ $order->id }}</td>
                            <td class="px-4 py-3">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3">{{ $order->user->username }}</td>
                            <td class="px-4 py-3">{{ $order->tree->treename }}</td>
                            <td class="px-4 py-3">{{ $order->tree->organization->organization_name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $order->amount }}</td>
                            <td class="px-4 py-3">{{ $order->total_price }}</td>
                        </tr>
                    @endforeach

                    @if ($treeorders->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center px-4 py-6 text-gray-500">No tree orders found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 ml-[5vw] z-1">
            {{ $treeorders->withQueryString()->links() }}
        </div>
    </div>

</body>
</html>