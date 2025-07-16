<?php

namespace App\Http\Controllers;

use App\Models\TreeOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tree; 
use App\Models\User; 

class TreeOrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $treeOrders = $user->treeOrders()->with('tree')->latest()->get();
        return response()->json($treeOrders); // Mengembalikan JSON, bukan view
    }

    public function store(Request $request)
    {
        $request->validate([
            'tree_id' => 'required|exists:trees,treeid',
            'amount' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $tree = Tree::find($request->tree_id);

        if (!$tree) {
            return back()->with('error', 'Pohon tidak ditemukan.');
        }

        $totalPrice = $tree->treeprice * $request->amount;

        if ($user->points < $totalPrice) {
            return back()->with('error', 'Poin Anda tidak cukup untuk menukarkan pohon ini.');
        }

        \DB::beginTransaction();
        try {
            // Kurangi poin user
            $user->points -= $totalPrice;
            $user->save();

            // Buat TreeOrder baru
            TreeOrder::create([
                'user_id' => $user->id,
                'tree_id' => $tree->treeid,
                'amount' => $request->amount,
                'total_price' => $totalPrice,
            ]);

            \DB::commit(); 

            return back()->with('success', "Berhasil menukarkan {$request->amount} pohon {$tree->treename}!");

        } catch (\Exception $e) {
            \DB::rollBack(); // Rollback transaksi jika ada error
            \Log::error('Error adopting tree: ' . $e->getMessage(), ['user_id' => $user->id, 'tree_id' => $tree->treeid]);
            return back()->with('error', 'Terjadi kesalahan saat menukarkan pohon. Silakan coba lagi.');
        }
    }
}