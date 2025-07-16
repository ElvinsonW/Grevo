<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tree;
use App\Models\Organization;
use Illuminate\Support\Facades\Log; // Pastikan ini ada

class TreeController extends Controller
{
    public function index()
    {
        $query = Tree::query();
        $trees = $query->paginate(10);
        return view('Admin.Tree.listtree', compact('trees'));
    }

    public function show(Request $request)
    {
        $selectedOrganizationId = $request->query('organization_id');

        $organizations = Organization::all();
        $query = Tree::query();
        $selectedOrganization = null;

        if (!empty($selectedOrganizationId)) {
            $selectedOrganization = Organization::find($selectedOrganizationId);

            if ($selectedOrganization) {
                $query->where('organization_id', $selectedOrganization->organization_id);
            }
        }

        $trees = $query->get();

        return view('User.treecatalogue.tree', [
            'trees' => $trees,
            'organizations' => $organizations,
            'selectedOrganization' => $selectedOrganization,
        ]);
    }
    
    public function see($treeName)
    {
        $tree = Tree::where('treename', $treeName)->firstOrFail();
        $similarTrees = Tree::where('treecategory', $tree->treecategory)
                            ->where('treeid', '!=', $tree->treeid)
                            ->inRandomOrder()
                            ->limit(4)
                            ->get();

        // aku pakek dummy dulu ya
        $treeBatches = collect([
            (object)['batch_name' => 'BATCH 30', 'description' => 'Tanggal + desc singkat apa gitu ya ges ya lalalall', 'planting_date' => now()->subDays(10)],
            (object)['batch_name' => 'BATCH 29', 'description' => 'Tanggal + desc singkat apa gitu ya ges ya lalalall', 'planting_date' => now()->subMonths(1)],
            (object)['batch_name' => 'BATCH 28', 'description' => 'Tanggal + desc singkat apa gitu ya ges ya lalalall', 'planting_date' => now()->subMonths(2)],
        ]);

        return view('User.treecatalogue.tree-detail', compact('tree', 'similarTrees', 'treeBatches'));
    }

    public function create()
    {
        $organizations = Organization::all();
        return view('Admin.Tree.addtree', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'treename' => 'required|string|max:255',
            'treecategory' => 'required|string|max:255',
            'treedesc' => 'required|string',
            'treelife' => 'required|integer',
            'treeprice' => 'required|decimal:0,5',
            'organization_id' => 'required|exists:organizations,organization_id',
            'treephoto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if($request->hasFile('treephoto')){
            $validated['treephoto'] = $request->file('treephoto')->store('treesphoto','public');
        }

        Tree::create($validated);

        return redirect()->route('tree.listtree')->with('success', 'Tree Added Successfully!');
    }

    public function edit(string $treeid)
    {
        $trees = Tree::findOrFail($treeid);
        $organizations = Organization::all();
        return view('Admin.Tree.edittree', compact('trees','organizations'));
    }

    public function update(Request $request, string $treeid)
    {
        $validated = $request->validate([
            'treename' => 'required|string|max:255',
            'treecategory' => 'required|string|max:255',
            'treedesc' => 'required|string',
            'treelife' => 'required|integer',
            'treeprice' => 'required|decimal:0,5',
            'organization_id' => 'required|exists:organizations,organization_id',
            'treephoto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $tree = Tree::findOrFail($treeid);

        if($request->hasFile('treephoto')){
            if ($tree->treephoto) {
                \Storage::disk('public')->delete($tree->treephoto);
            }
            $path = $request->file('treephoto')->store('treesphoto', 'public');
            $validated['treephoto'] = $path;
        }else{
            $validated['treephoto'] = $tree->treephoto;
        }

        $tree->update($validated);
        return redirect()->route('tree.listtree')->with('success', 'Tree Updated Successfully');
    }

    public function destroy(string $treeid)
    {
        $tree = Tree::findOrFail($treeid);
        if ($tree->treephoto) {
            \Storage::disk('public')->delete($tree->treephoto);
        }
        $tree->delete();

        return redirect()->route('tree.listtree')->with('success', 'Tree Deleted Successfully!');
    }
}