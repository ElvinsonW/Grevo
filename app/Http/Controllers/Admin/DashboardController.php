<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Orders bulan ini
        $orders = Order::with('items.variant.product.product_category')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        // Ambil semua item-nya
        $items = $orders->flatMap->items;

        $groupedItems = $items->groupBy('variant_id')->map(function ($group) {
            $item     = $group->first();
            $variant  = $item->variant;
            $product  = $variant->product;
            $category = $product->product_category;

            return (object)[
                'item'        => $item,
                'variant'     => $variant,
                'product'     => $product,
                'category'    => $category,
                'variant_id'  => $item->variant_id,
                'name'        => $item->variant->product->name,
                'varname'     => $item->variant->sku,
                'img'         => $item->variant->product->product_images->first()->image,
                'frequency'   => $group->sum('quantity'),
                'total_price' => $item->price,
            ];
        })->sortByDesc('frequency');

        // Top 5 Produk berdasarkan frekuensi pembelian
        $top5 = $groupedItems->take(5)->map(function ($data) {
            return (object)[
                'name'     => $data->name,
                'quantity' => $data->frequency,
                'variant'  => $data->variant,
                'product'  => $data->product,
            ];
        });

        // Perhitungan revenue
        $netrevenue = $groupedItems->sum('total_price');

        $now = [
            'total_orders' => $orders->count(),
            'sold_items'   => $items->count(),
            'net_revenue'  => $netrevenue,
            'total_sales'  => $netrevenue + $orders->sum('shipping'),
        ];

        // Data bulan lalu
        $prevorders = Order::with('items.variant.product')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->get();

        $previtems = $prevorders->flatMap->items;

        $prevgroupedItems = $previtems->groupBy('variant_id')->map(function ($group) {
            $item = $group->first();

            return (object)[
                'variant_id'  => $item->variant_id,
                'name'        => $item->name,
                'varname'     => $item->varname,
                'img'         => $item->img,
                'frequency'   => $group->sum('quantity'),
                'total_price' => $group->sum(fn($i) => $i->quantity * $i->price),
            ];
        });

        $last_netrevenue = $prevgroupedItems->sum('total_price');

        $comparator = [
            'last_orders'     => $prevorders->count(),
            'last_solditems'  => $previtems->count(),
            'last_netrevenue' => $last_netrevenue,
            'last_totalsales' => $last_netrevenue + $prevorders->sum('shipping'),
        ];

        // Weekly Data
        $weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $weeklyData = collect();

        for ($w = 1; $w <= 4; $w++) {
            $startOfWeek = Carbon::now()->startOfMonth()->addWeeks($w - 1)->startOfWeek();
            $endOfWeek   = $startOfWeek->copy()->endOfWeek();

            $weekOrders = Order::with('items')->whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
            $dayRevenue = collect();

            foreach ($weekdays as $i => $day) {
                $dayDate = $startOfWeek->copy()->addDays($i);

                $ordersForDay = $weekOrders->filter(
                    fn($order) =>
                    $order->created_at->isSameDay($dayDate)
                );

                $revenue = $ordersForDay->sum(
                    fn($order) =>
                    $order->items->sum(fn($item) => $item->quantity * $item->price)
                );

                $dayRevenue->push($revenue);
            }

            $weeklyData->put('Week ' . $w, $dayRevenue);
        }

        return view('Admin.dashboard', compact(
            'now',
            'groupedItems',
            'comparator',
            'weeklyData',
            'top5'
        ));
    }
}
