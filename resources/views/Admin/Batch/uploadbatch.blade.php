<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Proof</title>
    @vite('resources/css/app.css')
</head>
<body class="p-4 bg-yellow-2">
    @include('components.sidebar')
    <div class="px-20 py-4 mt-[3vw] ml-5">
        <h1 class="text-4xl font-bold mb-4 ml-5">Upload Proof</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 border rounded mb-4 ml-5">
                {{ session('success') }}
            </div>
        @endif

        <form class="w-full ml-5" action="{{ route('admin.batches.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="w-full flex flex-row gap-4">
                <!-- Left Column -->
                <div class="w-1/2 border border-green-2 flex flex-col gap-3 rounded-md p-4">
                    <!-- Organization -->
                    <div>
                        <p class="font-medium">Reforestation Organization</p>
                        <select name="organization_id" class="border w-full rounded-md p-2 border-green-2 bg-yellow-2" required>
                            <option value="">-- Select Organization -- </option>
                            @foreach($organizations as $org)
                                <option value="{{ $org->organization_id }}" {{ old('organization_id') == $org->organization_id ? 'selected' : '' }}>
                                    {{ $org->organization_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('organization_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Activity -->
                    <div>
                        <p class="font-medium">Date of Activity</p>
                        <input type="date" name="dateofactivity" class="border border-green-2 w-full rounded-md p-2" value="{{ old('dateofactivity') }}" required />
                        @error('dateofactivity')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Trees Planted -->
                    <div>
                        <p class="font-medium">Trees Planted</p>
                        <input type="number" name="treesplanted" class="border border-green-2 w-full rounded-md p-2" value="{{ old('treesplanted') }}" required />
                        @error('treesplanted')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Batch Date -->
                    <div>
                        <p class="font-medium">Start Date</p>
                        <input type="date" name="startdate" class="border border-green-2 w-full rounded-md p-2" value="{{ old('startdate') }}" required />
                        @error('startdate')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <p class="font-medium">End Date</p>
                        <input type="date" name="enddate" class="border border-green-2 w-full rounded-md p-2" value="{{ old('enddate') }}" required />
                        @error('enddate')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="w-1/2 border border-green-2 flex flex-col gap-3 rounded-md p-4">
                    <!-- Upload Photo -->
                    <div>
                        <p class="font-medium">Upload Photo</p>
                        <div class="relative w-full">
                            <input 
                                id="batchproof" 
                                type="file" 
                                name="batchproof" 
                                class="hidden" 
                                accept="image/*" 
                                onchange="previewImage(event)"
                                required
                            />

                            <label 
                                for="batchproof" 
                                class="cursor-pointer inline-block px-4 py-2 bg-green-2 text-white rounded hover:bg-green-3 text-center font-medium w-1/3">
                                Upload Batch Proof
                            </label>
                    </div>
                        @error('batchproof')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Preview -->
                        <div id="preview-container" class="mt-2">
                            <img id="preview" class="w-full h-40 object-contain border rounded-md" style="display: none;" />
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mt-5">Upload Proof</button>
            </div>
        </form>
    </div>

    <!-- Image Preview Script -->
    <script>
        function previewImage(event) {
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
