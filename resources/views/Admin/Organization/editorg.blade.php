<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Organization Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body class="p-5">
    @include('components.sidebar')
    <div class="px-20 py-4">
    <h1 class="text-4xl font-bold mb-4">Edit Reforestation Organization</h1>

    @if($errors->any())
      <div class="text-red-700 bg-red-100 border p-2 mb-4">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $error)
            <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if(session('success'))
      <div class="bg-green-100 text-green-700 p-2 border rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <form class="w-full" action="{{ route('organization.update', $organization->organization_id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="w-full flex flex-row gap-4">
        <div class="w-1/2 border flex flex-col gap-3 rounded-md p-4">
          <div>
            <p>Organization Name</p>
            <input type="text" name="organization_name" class="border w-full rounded-md p-1"
                   value="{{ old('organization_name', $organization->organization_name) }}" required />
          </div>
          <div>
            <p>Operational Address</p>
            <input type="text" class="border w-full rounded-md p-1" name="operational_address"
                   value="{{ old('operational_address', $organization->operational_address) }}" required />
          </div>
          <div>
            <p>Brief Description</p>
            <input type="text" class="border w-full h-20 rounded-md p-1" name="brief_description"
                   value="{{ old('brief_description', $organization->brief_description) }}" required />
          </div>
          <div>
            <p>Coverage Region</p>
            <input type="text" class="border w-full rounded-md p-1" name="coverage_region"
                   value="{{ old('coverage_region', $organization->coverage_region) }}" required />
          </div>
          <div>
            <p>Official Contact Info</p>
            <input type="text" class="border w-full rounded-md p-1" name="official_contact_info"
                   value="{{ old('official_contact_info', $organization->official_contact_info) }}" required />
          </div>
        </div>

        <div class="w-1/2 border flex flex-col gap-3 rounded-md p-4">
          <div>
            <p>Organization Logo</p>
              @if ($organization->organization_logo)
                <div class="mb-2">
                  <img src="{{ asset('storage/' . $organization->organization_logo) }}" alt="Current Logo" class="w-10 h-10 object-cover rounded-full">
                  <p class="text-sm text-gray-500">Current logo. Upload a new one to replace it.</p>
                </div>
              @endif
            <input type="file" class="border h-40 w-full rounded-md p-1" name="organization_logo" />
            <p class="text-sm text-gray-500 mt-1">Leave blank to keep existing logo.</p>
          </div>
          <div>
            <p>Types of Tree Planted</p>
            <input type="text" class="border w-full rounded-md p-1" name="types_of_tree_planted"
                   value="{{ old('types_of_tree_planted', $organization->types_of_tree_planted) }}" required />
          </div>
          <div>
            <p>Existing Partner or Sponsor (Optional)</p>
            <input type="text" class="border w-full rounded-md p-1" name="existing_partner_or_sponsor"
                   value="{{ old('existing_partner_or_sponsor', $organization->existing_partner_or_sponsor) }}" />
          </div>
          <div>
            <p>Organization Status</p>
              <select name="organization_status" class="border w-full rounded-md p-1" required>
                <option value="">-- Select Status --</option>
                <option value="Active" {{ old('organization_status', $organization->organization_status) == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Not Active" {{ old('organization_status', $organization->organization_status) == 'Not Active' ? 'selected' : '' }}>Not Active</option>
              </select>
          </div>
        </div>
      </div>

      <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mt-5">Save Changes</button>
      </div>
    </form>
</div>
</body>
</html>
