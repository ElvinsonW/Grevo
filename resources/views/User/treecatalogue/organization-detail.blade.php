{{-- resources/views/User/organization/detail.blade.php --}}

<x-layout>
    <div class="flex flex-col justify-center items-center bg-yellow-2">
        {{-- Banner section, similar to catalogue --}}
        @if ($organization->banner_image ?? false) {{-- Assuming you might add a banner_image column to Organization --}}
            <img src="{{ asset('storage/' . $organization->banner_image) }}" alt="Organization Banner" class="w-full h-[40vw] object-cover">
        @else
            {{-- Default banner if no specific banner image is available for the organization --}}
            <img src="{{ asset('images/default_organization_banner.png') }}" alt="Default Organization Banner" class="w-full h-[40vw] object-cover">
        @endif

        <div class="w-fit px-[7vw] py-[1.5vw] rounded-[1vw] bg-yellow-2 mt-[-6vw] mb-[3vw]">
            <h1 class="text-[5vw] font-bold text-green-2">{{ $organization->organization_name }}</h1>
        </div>

        <div class="flex flex-col w-full px-[5vw] gap-[6vw] items-center">
            <div class="flex flex-wrap lg:flex-nowrap gap-10 pl-[3vw] pr-[3vw] mb-[3vw] w-full max-w-[80vw]">
                <div class="flex flex-col items-center w-full lg:w-1/3">
                    <div class="w-[15vw] h-[15vw] bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden mb-5"
                        style="box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06);">
                        @if ($organization->organization_logo)
                            {{-- Assuming 'organization_logo' stores the path relative to storage/app/public --}}
                            <img src="{{ asset('storage/' . $organization->organization_logo) }}" alt="{{ $organization->organization_name }} Logo" class="w-full h-full object-contain">
                        @else
                            <span class="text-gray-500 text-[3vw]">LOGO</span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col w-full lg:w-2/3 max-h-fit rounded-lg p-8"
                    style="background-color: #FCFCF5; box-shadow: 0px 0px 12.2px 0px rgba(0,0,0,0.06);">
                    <h2 class="font-bold text-[#3E6137] text-[1.8vw] mb-4">DESCRIPTION GENERAL</h2>
                    <p class="text-[1.2vw] text-gray-700 mb-4">{{ $organization->brief_description }}</p>

                    <h2 class="font-bold text-[#3E6137] text-[1.8vw] mb-4">CONTACT INFORMATION</h2>
                    <p class="text-[1.2vw] text-gray-700"><strong>Address:</strong> {{ $organization->operational_address }}</p>
                    <p class="text-[1.2vw] text-gray-700"><strong>Coverage Region:</strong> {{ $organization->coverage_region }}</p>
                    <p class="text-[1.2vw] text-gray-700"><strong>Official Contact:</strong> {{ $organization->official_contact_info }}</p>
                    <p class="text-[1.2vw] text-gray-700"><strong>Status:</strong> {{ $organization->organization_status }}</p>
                    <p class="text-[1.2vw] text-gray-700"><strong>Partner/Sponsor:</strong> {{ $organization->existing_partner_or_sponsor }}</p>
                </div>
            </div>

            @if(isset($treesFromOrganization) && $treesFromOrganization->count() > 0)
                <div class="my-[2vw] px-[5vw] w-full">
                    <span class="flex items-center justify-center space-x-[16px] mb-10">
                        <h3 class="text-[20px] font-bold text-[#3E6137]">EXPLORE</h3>
                        <h1 class="text-[30px] font-bold text-[#D1764F]">TREES FROM THIS ORGANIZATION</h1>
                    </span>
                    <div class="flex flex-wrap gap-[1.5vw] justify-center">
                        @foreach ($treesFromOrganization as $tree)
                            @include("components.tree-card", ["tree" => $tree])
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Uncomment and adapt if you have a Batch model and pass $batchesFromOrganization --}}
            {{--
            @if(isset($batchesFromOrganization) && $batchesFromOrganization->count() > 0)
                <div class="my-[2vw] px-[5vw] w-full">
                    <span class="flex items-center justify-center space-x-[16px] mb-10">
                        <h3 class="text-[20px] font-bold text-[#3E6137]">EXPLORE</h3>
                        <h1 class="text-[30px] font-bold text-[#D1764F]">BATCHES FROM THIS ORGANIZATION</h1>
                    </span>
                    <div class="flex gap-4 mx-auto justify-center">
                        @foreach ($batchesFromOrganization as $batch)
                            <div class="flex flex-col w-[20vw] h-[26vw] rounded-[1vw] overflow-hidden" style="box-shadow: 0 0 12.2px 0 rgba(0,0,0,0.06);">
                                <div class="w-full h-[15vw] bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500 text-[1.5vw]">BATCH IMAGE</span>
                                </div>
                                <div class="p-[1vw] flex flex-col justify-between flex-grow">
                                    <h3 class="font-bold text-[#3E6137] text-[1.2vw] mb-[0.5vw]">
                                        @if($loop->first) (newest) @endif {{ $batch->batch_name ?? 'BATCH ' . $batch->id }}
                                    </h3>
                                    <p class="text-gray-600 text-[0.9vw] line-clamp-2 mb-[1vw]">{{ $batch->description ?? 'No description provided.' }}</p>
                                    <p class="text-gray-500 text-[0.8vw]">Planting Date: {{ $batch->planting_date ? $batch->planting_date->format('F d, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            --}}

        </div>
    </div>
</x-layout>