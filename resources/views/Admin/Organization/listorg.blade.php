<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization List</title>
    @vite('resources/css/app.css')
</head>
<body class="p-4 bg-yellow-2">
    @include('components.sidebar')

    <div class="w-[93vw] ml-[5vw] p-6">
        <div class="flex flex-row justify-between items-center mb-4">
            <h1 class="text-4xl font-bold">Organization List</h1>
        </div>

        <div class="flex flex-row justify-between">
        {{-- Filter Buttons --}}
            <div class="mb-4 flex gap-3">
                <a href="{{ route('admin.organizations.index', ['filter' => 'Active']) }}" 
                    class="px-3 py-2 rounded text-sm font-medium 
                        {{ request()->query('filter') == 'Active' ? 'bg-green-400 text-white' : 'bg-green-200 text-green-800 hover:bg-green-300' }}">
                    Active
                </a>
                <a href="{{ route('admin.organizations.index', ['filter' => 'Not Active']) }}" 
                    class="px-3 py-2 rounded text-sm font-medium 
                        {{ request()->query('filter') == 'Not Active' ? 'bg-red-400 text-white' : 'bg-red-200 text-red-800 hover:bg-red-300' }}">
                    Not Active
                </a>
            </div>
            <div class="mb-4">
                <a href="{{ route('admin.organizations.create') }}" class="px-2 py-3 bg-green-2 text-white rounded hover:bg-green-3 font-medium">
                    + Add New Organization
                </a>
            </div>
        </div>

        {{-- Organizations Table --}}
        <div class="bg-white rounded shadow">
            <table class="min-w-full text-sm">
                <thead class="bg-green-100 text-left">
                    <tr>
                        <th class="px-4 py-3">Organization Name</th>
                        <th class="px-4 py-3">Organization ID</th>
                        <th class="px-4 py-3">Address</th>
                        <th class="px-4 py-3">Contact Info</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-yellow-2">
                    @foreach ($organizations as $org)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 flex items-center gap-2">
                                <div class="w-6 h-6 bg-gray-300 rounded-full overflow-hidden">
                                    @if(!empty($org->organization_logo))
                                        <img class="w-full h-full object-cover" src="{{ asset('storage/' .$org->organization_logo) }}" alt="">
                                    @endif
                                </div>
                                {{ $org->organization_name }}
                            </td>
                            <td class="px-4 py-3">#{{ $org->organization_id }}</td>
                            <td class="px-4 py-3">{{ $org->operational_address }}</td>
                            <td class="px-4 py-3">{{ $org->official_contact_info }}</td>
                            <td class="px-4 py-3">
                                @if(strtolower($org->organization_status) == 'active')
                                    <span class="bg-green-200 text-green-800 px-2 py-1 rounded">Active</span>
                                @else
                                    <span class="bg-red-200 text-red-800 px-2 py-1 rounded">Not Active</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="relative group inline-block text-left">
                                    <button class="bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">...</button>
                                    <div class="absolute hidden group-hover:block bg-white border rounded shadow z-10 mt-1 right-0">
                                        <a href="{{ route('admin.organizations.edit', $org->organization_id) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Edit Organization</a>
                                        <form action="{{ route('admin.organizations.destroy', $org->organization_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this organization and all its associated trees?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">Delete Organization</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if ($organizations->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center px-4 py-6 text-gray-500">No organizations found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $organizations->withQueryString()->links() }}
        </div>
    </div>
</body>
</html>
