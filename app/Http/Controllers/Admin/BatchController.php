<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Organization;

class BatchController extends Controller
{
        public function index()
    {
        $query = Batch::query();

        $batches = $query->paginate(10);
        return view('Admin.Batch.listbatch', compact('batches'));
    }

    public function create()
    {
        $organizations = Organization::all();
        return view('Admin.Batch.uploadbatch', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id'=>'required|exists:organizations,organization_id',
            'dateofactivity' => 'required|date',
            'treesplanted' => 'required|integer',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'batchproof' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if($request->hasFile('batchproof')){
            $validated['batchproof'] = $request->file('batchproof')->store('batchproof','public');
        }

        Batch::create($validated);
        return redirect()->route('admin.batches.listbatch')->with('success','Batch Added Successfully!');
    }

    public function destroy(string $batchid)
    {
        //
        $batches = Batch::findOrFail($batchid);
        $batches->delete();

        return redirect()->route('Admin.Batch.listbatch')->with('success', 'Batch Deleted Successfully!');
    }
}
