<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
    use App\Models\TreeOrder;

class TreeOrderListController extends Controller
{
    public function index(){
        $treeorders = TreeOrder::with(['user', 'tree.organization'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Admin.Tree.tree-orders', compact('treeorders'));
    }
}
