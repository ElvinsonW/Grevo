<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderListController extends Controller
{
    public function index(Request $request)
    {
        $statusMap = [
            'new' => ['ORDER PLACED'],
            'shipping' => ['ORDER SHIPPED'],
            'arrived' => ['ORDER ARRIVED'],
            'done' => ['ORDER RECEIVED', 'ORDER COMPLETED'],
            'cancelled' => ['ORDER CANCELLED'],
        ];

        // Default ke 'new' jika parameter tidak ada
        $statusKey = $request->get('status', 'new');

        // Pastikan mapping tersedia
        $mappedStatuses = $statusMap[$statusKey] ?? [];

        $query = Order::with([
            'user',
            'items.variant.product',
            'latestStatus' // Relasi tunggal untuk status terbaru
        ])
        ->whereHas('latestStatus', function ($q) use ($mappedStatuses) {
            $q->whereIn('status', $mappedStatuses);
        });

        $orders = $query->orderByDesc('created_at')->paginate(10);

        return view('Admin.Product.order-list', compact('orders'));
    }

    public function storeStatusHistory(Request $request, Order $order)
    {
        $validStatuses = [
            'ORDER PLACED',
            'ORDER SHIPPED',
            'ORDER ARRIVED',
            'ORDER RECEIVED',
            'ORDER COMPLETED',
            'ORDER CANCELLED',
        ];

        $validated = $request->validate([
            'status' => ['required', Rule::in($validStatuses)],
        ]);

        $order->statusHistories()->create([
            'status' => $validated['status'],
            'changed_at' => now(),
        ]);

        return back()->with('success', 'Status berhasil ditambahkan.');
    }

}
