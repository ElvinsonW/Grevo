<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree List</title>
    @vite('resources/css/app.css')
</head>
<body class="p-4 bg-yellow-2">
    @include('components.sidebar')

    <div class="w-[93vw] p-4 ml-5 mt-5">
        <div class="flex flex-row justify-between items-center mb-4 ml-[5vw]">
            <h1 class="text-4xl font-bold">Tree List</h1>
            <a href="{{ route('admin.trees.create') }}" class="px-4 py-3 bg-green-2 text-white rounded hover:bg-green-3 font-medium">
                + Add New Tree
            </a>
        </div>

        <div class="bg-white rounded shadow ml-[5vw]">
            <table class="min-w-full text-sm">
                <thead class="bg-green-100 text-left">
                    <tr>
                        <th class="px-4 py-3">Tree Name</th>
                        <th class="px-4 py-3">Tree ID</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Lifespan</th>
                        <th class="px-4 py-3">Organization</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class ="bg-yellow-2">
                    @foreach ($trees as $tree)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 flex items-center gap-2">
                                <div class="w-6 h-6 bg-gray-300 rounded-full overflow-hidden">
                                    @if(!empty($tree->treephoto))
                                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $tree->treephoto) }}" alt="Tree">
                                    @endif
                                </div>
                                {{ $tree->treename }}
                            </td>
                            <td class="px-4 py-3">#{{ $tree->treeid }}</td>
                            <td class="px-4 py-3">{{ $tree->treeprice }}</td>
                            <td class="px-4 py-3">{{ $tree->treecategory }}</td>
                            <td class="px-4 py-3">{{ $tree->treelife }}</td>
                            <td class="px-4 py-3">{{ $tree->organization->organization_name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 relative">
                                <div class="relative group inline-block text-left">
                                    <button class="bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">...</button>
                                    <div class="absolute hidden group-hover:block bg-white border rounded shadow z-10 mt-1 right-0 min-w-[140px]">
                                        <a href="{{ route('admin.trees.edit', $tree->treeid) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Edit</a>
                                        <form action="{{ route('admin.trees.destroy', $tree->treeid) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if ($trees->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center px-4 py-6 text-gray-500">No trees found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 ml-[5vw] z-1">
            {{ $trees->withQueryString()->links() }}
        </div>
    </div>
</body>
</html>
