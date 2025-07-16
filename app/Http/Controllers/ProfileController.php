<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Order;
use App\Models\StatusHistory;
use App\Models\OrderItem;
use App\Models\Address; // Pastikan ini di-import jika Anda menggunakan model Address
use App\Models\Review;
use App\Models\TreeOrder;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view('User.edit-profile.edit-profile', compact('user'));
    }

    /**
     * Menampilkan halaman daftar alamat pengguna.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showAddresses()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat alamat.');
        }

        $addresses = $user->addresses; // Menggunakan relasi hasMany

        return view('User.edit-profile.addresses', compact('user', 'addresses'));
    }

    /**
     * Menampilkan halaman daftar pesanan pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function showOrders(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->input('keyword');
        $statusParam = $request->input('status', 'all');

        $statusMap = [
            'to-ship'    => ['ORDER PLACED'],
            'to-receive' => ['ORDER SHIPPED'],
            'delivered'  => ['ORDER ARRIVED'],
            'completed'  => ['ORDER RECEIVED', 'ORDER COMPLETED'],
            'cancelled'  => ['CANCELLED'],
        ];

        $orders = Order::with(['items', 'statusHistories' => fn($q) => $q->orderBy('changed_at', 'desc')])
            ->where('user_id', $user->id)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('order_id', 'like', "%$keyword%")
                      ->orWhereHas('items', fn ($iq) => $iq->where('name', 'like', "%$keyword%"));
                });
            })
            ->get();

        if ($statusParam !== 'all' && isset($statusMap[$statusParam])) {
            $statuses = $statusMap[$statusParam];
            $orders = $orders->filter(function ($order) use ($statuses) {
                $latestStatus = $order->statusHistories->first()->status ?? null;
                return in_array($latestStatus, $statuses);
            });
        }

        return view('User.orders.history', compact('user', 'orders'));
    }

    /**
     * Menampilkan halaman daftar ulasan pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function showReviews()
    {
        $user = Auth::user();
        return view('User.edit-profile.user-review', [
            "user" => $user,
            "reviews" => Review::where("user_id", $user->id)->paginate(10)
        ]);
    }

    public function showTreeOrder(){
        $user = Auth::user();
        return view('User.edit-profile.tree-order',[
            "user" => $user,
            "treeOrders" => TreeOrder::where('user_id', $user->id)->get()
        ]);
    }
}