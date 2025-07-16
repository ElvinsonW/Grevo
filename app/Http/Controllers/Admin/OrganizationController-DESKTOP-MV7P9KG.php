<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tree;
use App\Models\Organization;

class OrganizationController extends Controller
{
    //
    public function create()
    {
        return view('Admin.Organization.addorg');
    }

    // aku nambahin fungsi ini buat nampilin di detail organisasi nanti
    public function show($organizationName)
    {
        $organization = Organization::where('organization_name', $organizationName)->firstOrFail();
        $treesFromOrganization = Tree::where('organization_id', $organization->id)->get();
        return view('User.treecatalogue.organization-detail', compact('organization', 'treesFromOrganization' /* , 'batchesFromOrganization' */));
    }

    public function index(Request $request)
    {
        $filter = $request->query('filter', 'Active');
        $query = Organization::query();

        if ($filter) {
            $query->where('organization_status', $filter);
        }

        $organizations = $query->paginate(10);
        return view('Admin.Organization.listorg', compact('organizations')); // Must be passed like this
    }

    public function edit($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);
        return view('Admin.Organization.editorg', compact('organization'));
    }

    public function update(Request $request, $organization_id)
    {
        $validated = $request->validate([
            'organization_name'=>'required|string|max:255',
            'operational_address'=>'required|string',
            'brief_description'=>'required|string',
            'coverage_region'=>'required|string',
            'official_contact_info'=>'required|string',
            'organization_logo'=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'existing_partner_or_sponsor' =>'nullable|string',
            'organization_status' =>'required|string'
        ]);

        $organization = Organization::findorFail($organization_id);

        $organization->update($request->only([
            'organization_name','operational_address','brief_description','coverage_region','official_contact_info','types_of_trees_planted','existing_partner_or_sponsor','organization_status'
        ]));

        if ($request->hasFile('organization_logo')) {
            // Delete old logo if exists
            // if ($organization->organization_logo && Storage::disk('logos')->exists($organization->organization_logo)) {
            //     Storage::disk('logos')->delete($organization->organization_logo);
            // }
            $logo = $request->file('organization_logo');
            $filename = time().'_'.$logo->getClientOriginalName();
            $path = $request->file('organization_logo')->store('logos', 'public');
            $validated['organization_logo'] = $path;
        } else {
            $validated['organization_logo'] = $organization->organization_logo;
        }

        $organization->update($validated);

        return redirect()->route('admin.organizations.index')->with('success', 'Organization Updated Successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name'=>'required|string|max:255',
            'operational_address'=>'required|string',
            'brief_description'=>'required|string',
            'coverage_region'=>'required|string',
            'official_contact_info'=>'required|string',
            'organization_logo'=> 'required|image|mimes:jpeg,png,jpg|max:2048',
            'existing_partner_or_sponsor' =>'nullable|string',
            'organization_status' =>'required|string'
        ]);

        if($request->hasFile('organization_logo')){
            $validated['organization_logo'] = $request->file('organization_logo')->store('logos','public');
        }

        Organization::create($validated);

        return redirect()->route('admin.organizations.index')->with('success', 'Organization added successfully!');
    }

    public function destroy($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);

        // if($organization->organization_logo && Storage::disk('public')->exists($organization->organization_logo)){
        //     Storage::disk('public')->delete($organization->organization_logo);
        // }
        
        $organization->delete();

        return redirect()->route('admin.organizations.index')->with('success','Organization and associated trees deleted successfully!');
    }
} 