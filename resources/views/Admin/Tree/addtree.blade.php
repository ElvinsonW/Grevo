<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tree</title>
    @vite('resources/css/app.css')
</head>
<body class="p-4 bg-yellow-2">
    @include('components.sidebar')

    <div class="px-20 py-6">
        <h1 class="text-4xl font-bold mb-4 ml-4">Add Tree</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 border rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form class="w-full" action="{{ route('admin.trees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="w-full flex flex-row gap-4 ml-4">
                <!-- Left Column -->
                <div class="w-1/2 border border-green-2 bg-yellow-2 flex flex-col gap-3 rounded-md p-4">
                    <div>
                        <p class="font-medium">Tree Name</p>
                        <input type="text" name="treename" value="{{ old('treename') }}" class="border border-green-2 w-full rounded-md p-2" required />
                        @error('treename')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <p class="font-medium">Tree Category</p>
                        <input type="text" name="treecategory" value="{{ old('treecategory') }}" class="border border-green-2 w-full rounded-md p-2" required />
                        @error('treecategory')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <p class="font-medium">Tree Description</p>
                        <textarea name="treedesc" class="border border-green-2 w-full h-20 rounded-md p-2" required>{{ old('treedesc') }}</textarea>
                        @error('treedesc')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <p class="font-medium">Tree Lifespan (Years)</p>
                        <input type="number" name="treelife" value="{{ old('treelife') }}" class="border border-green-2 w-full rounded-md p-2" required />
                        @error('treelife')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <p class="font-medium">Tree Price</p>
                        <input type="number" name="treeprice" step="0.01" value="{{ old('treeprice') }}" class="border border-green-2 w-full rounded-md p-2" required />
                        @error('treeprice')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="w-1/2 border border-green-2 bg-yellow-2 flex flex-col gap-3 rounded-md p-4">
                    <div>
                        <p class="font-medium">Reforestation Organization</p>
                        <select name="organization_id" class="border border-green-2 w-full rounded-md p-2 bg-yellow-2" required>
                            <option value="">-- Select Organization --</option>
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

                    <div>
                        <p class="font-medium">Tree Photo</p>
                        <div class="relative w-full">
                        <input 
                            id="treephoto" 
                            type="file" 
                            name="treephoto" 
                            class="hidden" 
                            accept="image/*" 
                            onchange="previewImage(event)"
                        />

                        <label 
                            for="treephoto" 
                            class="cursor-pointer inline-block px-4 py-2 bg-green-2 text-white rounded hover:bg-green-3 text-center font-medium w-1/3">
                            Upload Tree Photo
                        </label>
                    </div>

                        @error('treephoto')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <div id="preview-container" class="mt-2">
                            <img id="preview" class="w-full h-40 object-contain border rounded-md" style="display: none;" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="ml-4">
                <button type="submit" class="bg-green-2 text-white px-4 py-2 rounded-md hover:bg-green-3 mt-5 font-medium">Add Tree</button>
            </div>
        </form>
    </div>

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
