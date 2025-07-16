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

    <div class="w-[93vw] p-5 ml-5 mt-5">
        @if (session('loginSuccess'))
            <div class="alert absolute z-40 flex items-center justify-center p-4 mb-4 w-[30vw] text-green-800 rounded-lg bg-green-50"
                style="top: 10%; left: 50%; transform: translate(-50%, -50%);" role="alert">
                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('loginSuccess') }}
                </div>
                <button type="button"
                    class="close-button ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 data-dismiss-target="#alert-3"
                    aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
        <div class="flex flex-row justify-between items-center mb-4 ml-[5vw]">
            <h1 class="text-4xl font-bold">Dashboard</h1>
        </div>

        <div class="ml-[5vw]">
            <!-- Summary Cards -->
            <div class="grid grid-cols-4 gap-6 mb-8">
                @foreach ($now as $key => $value)
                    @php
                        $last = $comparator['last_' . $key] ?? 0;
                        $diff = $value - $last;
                        $base = $last ?: 1; // Hindari divide by zero
                        $growth = round(($diff / $base) * 100, 2);
                        $status = $growth >= 0 ? 'increase' : 'decrease';

                        $label = Str::title(str_replace('_', ' ', $key));

                    @endphp

                    <div class="bg-[#DDECD5] p-4 rounded-lg shadow">
                        <div class="flex flex-row gap-6 items-center mb-3">
                            <img src="{{ asset('images/' . $key . '.svg') }}" alt="image" class="h-13 w-auto">
                            <div>

                                <h2 class="text-sm font-semibold text-gray-700 mb-[-5px]">{{ $label }}</h2>
                                <div class="flex flex-row gap-4 items-center">
                                    @if (($key === 'total_sales') | ($key === 'net_revenue'))
                                        <p class="text-xl font-bold mt-2">Rp {{ number_format($value, 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="text-xl font-bold mt-2">{{ number_format($value, 0, ',', '.') }}</p>
                                    @endif
                                    @if ($status === 'increase')
                                        <img src="{{ asset('images/increase.svg') }}" alt=""
                                            class="h-10 w-auto">
                                    @else
                                        <img src="{{ asset('images/decrease.svg') }}" alt=""
                                            class="h-10 w-auto">
                                    @endif
                                </div>
                            </div>

                        </div>
                        @if ($last == 0)
                            <p class="text-xs text-gray-500">new this month</p>
                        @else
                            <p class="text-xs text-gray-500">{{ abs($growth) }}% {{ $status }} from last month
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- graphs -->
            <div class="flex flex-row gap-10">
                <!-- Line Chart -->
                <div class="bg-[#E7F2E1] p-6 rounded shadow mb-8 w-5/7">
                    <h2 class="text-xl font-semibold mb-4">Sales Report</h2>
                    <canvas id="weeklyChart" class="w-full max-h-[350px]"></canvas>
                </div>

                <!-- Pie Chart -->
                <div class="bg-[#E7F2E1] p-10 rounded shadow mb-8">
                    <h2 class="text-xl font-semibold mb-4">Top 5 Products</h2>
                    <canvas id="top5Chart" class="w-full max-h-[350px]"></canvas>
                </div>
            </div>


            <!-- sold items -->
            <h1 class="text-xl font-semibold mb-4">Product Sales</h1>
            <table class="min-w-full text-sm">
                <thead class="bg-[#DDECD5] text-left">
                    <tr>
                        <th class="px-4 py-3">No.</th>
                        <th class="px-4 py-3">Product Name</th>
                        <th class="px-4 py-3">Variant</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Sold</th>
                    </tr>
                </thead>
                <tbody class="bg-yellow-2">
                    @foreach ($groupedItems as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-medium">{{ $item->variant->product->name }}</td>
                            <td class="px-4 py-3">{{ $item->varname }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($item->variant->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ $item->category->name }}</td>
                            <td class="px-4 py-3">{{ $item->frequency }}</td>

                        </tr>
                    @endforeach

                    @if ($groupedItems->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center px-4 py-6 text-gray-500">No products sold.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>


<!-- js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('weeklyChart');

    const data = {
        labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        datasets: [
            @foreach ($weeklyData as $week => $revenues)
                {
                    label: "{{ $week }}",
                    data: {!! json_encode($revenues) !!},
                    borderColor: '{{ ['#FEF5E4', '#FEE3C6', '#FFBEC2', '#FAA2AE', '#A7B7BE'][$loop->index] }}',
                    backgroundColor: 'transparent',
                    tension: 0.3,
                    pointRadius: 3
                },
            @endforeach
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return `Rp${ctx.raw.toLocaleString()}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => `Rp${value.toLocaleString()}`
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
</script>

<!-- pie chart => top 5 -->
<script>
    const top5Ctx = document.getElementById('top5Chart');

    const top5Data = {
        labels: {!! json_encode($top5->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($top5->pluck('quantity')) !!},
            backgroundColor: [
                '#FEF5E4', '#FEE3C6', '#FFBEC2', '#FAA2AE', '#A7B7BE'
            ],
            borderWidth: 0,
            hoverOffset: 6
        }]
    };

    const top5Config = {
        type: 'pie',
        data: top5Data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 12
                        },
                        usePointStyle: true
                    },
                },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw.toLocaleString()} items`
                    }
                }
            }
        }
    };

    new Chart(top5Ctx, top5Config);

    const closeButtons = document.querySelectorAll('.close-button');

    closeButtons.forEach((button) => {
        button.addEventListener('click', function() {
            const alert = button.closest('.alert')
            alert.style.display = "none";
        });
    });

    const alerts = document.querySelectorAll('.alert');

    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.display = "none";
        }, 3000); 
    });
</script>
