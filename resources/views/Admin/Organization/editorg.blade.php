<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Organization Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body class="p-6 bg-yellow-2">
  @include('components.sidebar')

  <div class="px-20 py-4 ml-[2vw] mt-5">
    <h1 class="text-4xl font-bold mb-4">Edit Reforestation Organization</h1>

    @if(session('success'))
      <div class="bg-green-100 text-green-700 p-2 border rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <form class="w-[80vw]" action="{{ route('admin.organizations.update', $organization->organization_id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="w-full flex flex-row gap-4">
        <!-- LEFT COLUMN -->
        <div class="w-1/2 border border-green-2 flex flex-col gap-3 rounded-md p-4">
          <div>
            <p class="font-medium">Organization Name</p>
            <input type="text" name="organization_name" class="border border-green-2 w-full rounded-md p-2"
                   value="{{ old('organization_name', $organization->organization_name) }}" required />
            @error('organization_name')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <p class="font-medium">Operational Address</p>
            <input type="text" name="operational_address" class="border border-green-2 w-full rounded-md p-2"
                   value="{{ old('operational_address', $organization->operational_address) }}" required />
            @error('operational_address')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <p class="font-medium">Brief Description</p>
            <textarea name="brief_description" class="border border-green-2 w-full h-20 rounded-md p-2" required>{{ old('brief_description', $organization->brief_description) }}</textarea>
            @error('brief_description')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <p class="font-medium">Coverage Region</p>
            <input type="text" name="coverage_region" class="border border-green-2 w-full rounded-md p-2"
                   value="{{ old('coverage_region', $organization->coverage_region) }}" required />
            @error('coverage_region')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <p class="font-medium">Official Contact Info</p>
            <input type="text" name="official_contact_info" class="border border-green-2 w-full rounded-md p-2"
                   value="{{ old('official_contact_info', $organization->official_contact_info) }}" required />
            @error('official_contact_info')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="w-1/2 border flex flex-col gap-3 rounded-md p-4">
          <div>
            <p class="font-medium">Organization Logo</p>
            @if ($organization->organization_logo)
              <div class="mb-2">
                <img src="{{ asset('storage/' . $organization->organization_logo) }}" alt="Current Logo" class="w-10 h-10 object-cover rounded-full">
                <p class="text-sm text-gray-500">Current logo. Upload a new one to replace it.</p>
              </div>
            @endif
                    <div class="relative w-full">
                        <input 
                            id="organization_logo" 
                            type="file" 
                            name="organization_logo" 
                            class="hidden" 
                            accept="image/*" 
                            onchange="previewLogo(event)"
                        />

                        <label 
                            for="organization_logo" 
                            class="cursor-pointer inline-block px-4 py-2 bg-green-2 text-white rounded hover:bg-green-3 text-center font-medium w-1/2">
                            Upload Organization Logo
                        </label>
                    </div>
            @error('organization_logo')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Preview -->
            <div id="preview-container" class="mt-2">
              <img id="preview" class="w-full h-40 object-contain border border-green-2 rounded-md" style="display: none;" />
            </div>
          </div>

          <div>
            <p class="font-medium">Existing Partner or Sponsor (Optional)</p>
            <input type="text" name="existing_partner_or_sponsor" class="border border-green-2 w-full rounded-md p-2"
                   value="{{ old('existing_partner_or_sponsor', $organization->existing_partner_or_sponsor) }}" />
            @error('existing_partner_or_sponsor')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <p class="font-medium">Organization Status</p>
            <select name="organization_status" class="border border-green-2 bg-yellow-2 w-full rounded-md p-2" required>
              <option value="">-- Select Status --</option>
              <option value="Active" {{ old('organization_status', $organization->organization_status) == 'Active' ? 'selected' : '' }}>Active</option>
              <option value="Not Active" {{ old('organization_status', $organization->organization_status) == 'Not Active' ? 'selected' : '' }}>Not Active</option>
            </select>
            @error('organization_status')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <div>
        <button type="submit" class="bg-green-2 text-white px-4 py-2 rounded-md hover:bg-green-3 font-medium mt-5">Save Changes</button>
      </div>
    </form>
  </div>

    <!-- JS for Image Preview -->
  <script>
    function previewLogo(event) {
      const reader = new FileReader();
      reader.onload = function () {
        const output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
      };
      if (event.target.files.length > 0) {
        reader.readAsDataURL(event.target.files[0]);
      }
    }
  </script>
</body>
</html>
