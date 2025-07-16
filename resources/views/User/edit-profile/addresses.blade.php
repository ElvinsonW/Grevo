<x-layout>
    <div class="flex mx-[5vw] my-[2vw]">
        {{-- Pastikan x-profilebar tersedia dan berfungsi --}}
        <x-profilebar :user="$user" />

        <div class="flex flex-col ml-[2vw] w-full">
            {{-- Filter Bar --}}
            <div class="flex border-b border-gray-300 mb-[3vw] text-[1.2vw]">
                <a href="{{ route('profile') }}"
                    class="py-[0.75vw] px-[2vw] text-gray-600 hover:text-[var(--color-green-3)] border-r border-gray-300">Profile</a>
                <a href="{{ route('addresses') }}"
                    class="py-[0.75vw] px-[2vw] text-[var(--color-green-3)] font-bold border-b-[0.2vw] border-[var(--color-green-3)] -mb-px">Addresses</a>
            </div>

            {{-- Header with Add New Address Button --}}
            <div class="flex justify-between items-center mb-[3vw]">
                <h1 class="text-[2vw] font-bold">Addresses</h1>
                <button type="button" id="addAddressBtn"
                    class="px-[1.5vw] py-[0.75vw] text-[1vw] rounded-[0.3vw] bg-[var(--color-green-3)] text-white hover:bg-[var(--color-green-2)]">
                    + Add New Address
                </button>
            </div>

            {{-- Success Message (if any) --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-[1vw]"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.closest('[role=alert]').remove()">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.15a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.15 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            @endif

            {{-- Address List Container --}}
            <div class="grid grid-cols-1 gap-[1vw]">
                @forelse ($addresses as $address)
                    <div class="border border-gray-300 rounded-[0.5vw] p-[1.5vw] flex flex-col lg:flex-row justify-between items-start lg:items-center bg-white shadow-sm"
                        data-id="{{ $address->id }}" data-recipient-name="{{ $address->recipient_name }}"
                        data-phone-number="{{ $address->phone_number }}"
                        data-street-address="{{ $address->street_address }}" data-city="{{ $address->city }}"
                        data-province="{{ $address->province }}" data-urban-village="{{ $address->urban_village }}"
                        data-subdistrict="{{ $address->subdistrict }}" data-label="{{ $address->label }}"
                        data-is-default="{{ $address->is_default ? 'true' : 'false' }}"
                        data-postal-code="{{ $address->postal_code }}">

                        <div class="flex-grow">
                            <p class="text-[1.2vw] font-semibold text-gray-800">{{ $address->recipient_name }} <span
                                    class="ml-[0.5vw] text-gray-600">{{ $address->phone_number }}</span></p>
                            <p class="text-[0.9vw] text-gray-700 mt-[0.25vw]">{{ $address->street_address }}</p>
                            <p class="text-[0.9vw] text-gray-500">
                                {{ implode(
                                    ', ',
                                    array_filter([$address->urban_village, $address->subdistrict, $address->city, $address->province, $address->postal_code]),
                                ) }}
                            </p>

                            <div class="flex items-center gap-[0.5vw] mt-[0.5vw]">
                                @if ($address->is_default)
                                    <span class="px-[1vw] py-[0.25vw] text-[0.8vw] font-semibold rounded-full"
                                        style="background-color: var(--color-green-1); color: var(--color-green-2);">Default</span>
                                @endif
                                @if ($address->label)
                                    <span
                                        class="px-[1vw] py-[0.25vw] text-[0.8vw] font-semibold rounded-full bg-gray-200 text-gray-700">{{ $address->label }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div
                            class="flex flex-col lg:flex-row items-end lg:items-center gap-[0.5vw] mt-[1vw] lg:mt-0 lg:ml-[2vw]">
                            <button type="button"
                                class="edit-address-btn text-[0.9vw] text-gray-500 hover:text-blue-600">Edit</button>
                            <form action="{{ route('addresses.destroy', $address) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this address?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-[0.9vw] text-gray-500 hover:text-red-600">Delete</button>
                            </form>
                            @if (!$address->is_default)
                                <form action="{{ route('addresses.setDefault', $address) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="px-[1.2vw] py-[0.5vw] text-[0.9vw] rounded-[0.3vw] border border-gray-300 text-gray-600 hover:bg-gray-100">Set
                                        as Default</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-[1vw] text-center py-[2vw]">No addresses found.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- MODAL UNTUK EDIT ADDRESS --}}
    <div id="editAddressModal" class="fixed inset-0 bg-black/75 flex items-center justify-center z-50 hidden">
        <div class="bg-yellow-2 rounded-[0.5vw] p-[2vw] shadow-lg w-[40vw] max-h-[90vh] overflow-y-auto relative">
            {{-- Close Button --}}
            <button id="closeEditModal"
                class="absolute top-[1vw] right-[1vw] text-gray-500 hover:text-gray-700 text-[1.5vw]">
                &times;
            </button>

            <h2 class="text-[1.8vw] font-bold mb-[2vw]">Edit Address</h2>

            {{-- Form Edit Address --}}
            <form id="editAddressForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-[1.5vw] mb-[1.5vw]">
                    <div>
                        <label for="edit_recipient_name"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Full Name</label>
                        <input type="text" name="recipient_name" id="edit_recipient_name"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('recipient_name') border-red-500 @enderror"
                            required value="{{ session('old_edit_data.recipient_name', '') }}">
                        @error('recipient_name')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="edit_phone_number"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Phone Number</label>
                        <input type="text" name="phone_number" id="edit_phone_number"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('phone_number') border-red-500 @enderror"
                            required value="{{ session('old_edit_data.phone_number', '') }}">
                        @error('phone_number')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-[1.5vw]">
                    <label for="edit_province"
                        class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Province</label>
                    <input type="text" name="province" id="edit_province"
                        class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('province') border-red-500 @enderror"
                        required value="{{ session('old_edit_data.province', '') }}">
                    @error('province')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-[1.5vw] mb-[1.5vw]">
                    <div>
                        <label for="edit_city"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">City</label>
                        <input type="text" name="city" id="edit_city"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('city') border-red-500 @enderror"
                            required value="{{ session('old_edit_data.city', '') }}">
                        @error('city')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="edit_subdistrict"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Subdistrict
                            (Kecamatan)</label>
                        <input type="text" name="subdistrict" id="edit_subdistrict"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('subdistrict') border-red-500 @enderror"
                            value="{{ session('old_edit_data.subdistrict', '') }}">
                        @error('subdistrict')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-[1.5vw] mb-[1.5vw]">

                    <div>
                        <label for="edit_urban_village"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Urban Village
                            (Kelurahan/Desa)</label>
                        <input type="text" name="urban_village" id="edit_urban_village"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('urban_village') border-red-500 @enderror"
                            value="{{ session('old_edit_data.urban_village', '') }}">
                        @error('urban_village')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="edit_postal_code"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Postal Code
                            (Kode Pos)</label>
                        <input type="text" name="postal_code" id="edit_postal_code"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('postal_code') border-red-500 @enderror"
                            value="{{ session('old_edit_data.postal_code', '') }}">
                        @error('postal_code')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mb-[1.5vw]">
                    <label for="edit_street_address"
                        class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Street Name, Building, House
                        Number</label>
                    <textarea name="street_address" id="edit_street_address" rows="3"
                        class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('street_address') border-red-500 @enderror"
                        required>{{ session('old_edit_data.street_address', '') }}</textarea>
                    @error('street_address')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-[1.5vw]">
                    <label class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Label As</label>
                    <div class="flex gap-[1vw]">
                        <label class="focus:outline-none inline-flex items-center">
                            <input type="radio" name="label" value="Home"
                                class="form-radio text-[var(--color-green-3)]" id="edit_label_home">
                            <span
                                class="ml-[0.5vw] text-[0.9vw] text-gray-700 border border-gray-300 px-[1vw] py-[0.5vw] rounded-[0.3vw] cursor-pointer has-[:checked]:bg-[var(--color-green-1)] has-[:checked]:border-[var(--color-green-3)] has-[:checked]:text-[var(--color-green-3)]">Home</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="label" value="Work"
                                class="form-radio text-[var(--color-green-3)]" id="edit_label_work">
                            <span
                                class="ml-[0.5vw] text-[0.9vw] text-gray-700 border border-gray-300 px-[1vw] py-[0.5vw] rounded-[0.3vw] cursor-pointer has-[:checked]:bg-[var(--color-green-1)] has-[:checked]:border-[var(--color-green-3)] has-[:checked]:text-[var(--color-green-3)]">Work</span>
                        </label>
                    </div>
                    @error('label')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-[1vw]">
                    <button type="button" id="cancelEditModal"
                        class="font-bold px-[2.5vw] py-[0.75vw] text-[1vw] border border-orange-1 rounded-[0.3vw] text-orange-1 hover:border-green-2">Cancel</button>
                    <button type="submit"
                        class="font-bold px-[2.5vw] py-[0.75vw] text-[1vw] rounded-[0.3vw] bg-orange-1 text-white hover:bg-green-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
    {{-- AKHIR MODAL EDIT --}}

    {{-- MODAL UNTUK ADD NEW ADDRESS --}}
    <div id="addAddressModal" class="fixed inset-0 bg-black/75 flex items-center justify-center z-50 hidden">
        <div class="bg-yellow-2 rounded-[0.5vw] p-[2vw] shadow-lg w-[40vw] max-h-[90vh] overflow-y-auto relative">
            {{-- Close Button --}}
            <button id="closeAddModal"
                class="absolute top-[1vw] right-[1vw] text-gray-500 hover:text-gray-700 text-[1.5vw]">
                &times;
            </button>

            <h2 class="text-[1.8vw] font-bold mb-[2vw]">Add New Address</h2>

            {{-- Form Add New Address --}}
            <form id="addAddressForm" action="{{ route('addresses.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-[1.5vw] mb-[1.5vw]">
                    <div>
                        <label for="add_recipient_name"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Recipient Name</label>
                        <input type="text" name="recipient_name" id="add_recipient_name"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('recipient_name') border-red-500 @enderror"
                            required value="{{ old('recipient_name') }}">
                        @error('recipient_name')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="add_phone_number"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Phone Number</label>
                        <input type="text" name="phone_number" id="add_phone_number"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('phone_number') border-red-500 @enderror"
                            required value="{{ old('phone_number') }}">
                        @error('phone_number')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-[1.5vw]">
                    <label for="add_province"
                        class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Province</label>
                    <input type="text" name="province" id="add_province"
                        class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('province') border-red-500 @enderror"
                        required value="{{ old('province') }}">
                    @error('province')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-[1.5vw] mb-[1.5vw]">
                    <div>
                        <label for="add_city"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">City</label>
                        <input type="text" name="city" id="add_city"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('city') border-red-500 @enderror"
                            required value="{{ old('city') }}">
                        @error('city')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="add_subdistrict"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Subdistrict
                            (Kecamatan)</label>
                        <input type="text" name="subdistrict" id="add_subdistrict"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('subdistrict') border-red-500 @enderror"
                            value="{{ old('subdistrict') }}">
                        @error('subdistrict')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-[1.5vw] mb-[1.5vw]">
                    <div>
                        <label for="add_urban_village"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Urban Village
                            (Kelurahan/Desa)</label>
                        <input type="text" name="urban_village" id="add_urban_village"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('urban_village') border-red-500 @enderror"
                            value="{{ old('urban_village') }}">
                        @error('urban_village')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="add_postal_code"
                            class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Postal Code
                            (Kode Pos)</label>
                        <input type="text" name="postal_code" id="add_postal_code"
                            class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('postal_code') border-red-500 @enderror"
                            value="{{ old('postal_code', '') }}">
                        @error('postal_code')
                            <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-[1.5vw]">
                    <label for="add_street_address"
                        class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Street Name, Building, House
                        Number</label>
                    <textarea name="street_address" id="add_street_address" rows="3"
                        class="focus:outline-none w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500 @error('street_address') border-red-500 @enderror"
                        required>{{ old('street_address') }}</textarea>
                    @error('street_address')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-[1.5vw]">
                    <label class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Label As</label>
                    <div class="flex gap-[1vw]">
                        <label class="inline-flex items-center">
                            <input type="radio" name="label" value="Home"
                                class="form-radio text-[var(--color-green-3)]" id="add_label_home"
                                {{ old('label') == 'Home' ? 'checked' : '' }}>
                            <span
                                class="ml-[0.5vw] text-[0.9vw] text-gray-700 border border-gray-300 px-[1vw] py-[0.5vw] rounded-[0.3vw] cursor-pointer has-[:checked]:bg-[var(--color-green-1)] has-[:checked]:border-[var(--color-green-3)] has-[:checked]:text-[var(--color-green-3)]">Home</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="label" value="Work"
                                class="form-radio text-[var(--color-green-3)]" id="add_label_work"
                                {{ old('label') == 'Work' ? 'checked' : '' }}>
                            <span
                                class="ml-[0.5vw] text-[0.9vw] text-gray-700 border border-gray-300 px-[1vw] py-[0.5vw] rounded-[0.3vw] cursor-pointer has-[:checked]:bg-[var(--color-green-1)] has-[:checked]:border-[var(--color-green-3)] has-[:checked]:text-[var(--color-green-3)]">Work</span>
                        </label>
                    </div>
                    @error('label')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>
                @error('invalidAddress')
                    <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                @enderror

                <div class="flex justify-end gap-[1vw]">
                    <button type="button" id="cancelAddModal"
                        class="px-[1.5vw] py-[0.75vw] text-[1vw] border border-gray-300 rounded-[0.3vw] text-gray-700 hover:bg-gray-100">Cancel</button>
                    <button type="submit"
                        class="px-[1.5vw] py-[0.75vw] text-[1vw] rounded-[0.3vw] bg-[var(--color-green-3)] text-white hover:bg-[var(--color-green-2)]">Add
                        Address</button>
                </div>
            </form>
        </div>
    </div>
    {{-- AKHIR MODAL ADD NEW ADDRESS --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded. Addresses script is running.');

            // JavaScript for sidebar dropdown (unchanged)
            const toggle = document.getElementById('profile-menu');
            const menu = document.getElementById('profile-dropdown');
            const icon = document.getElementById('dropdown-icon');

            if (toggle && menu && icon) {
                toggle.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                    menu.classList.toggle('flex');
                    icon.classList.toggle('rotate-180');
                });
            }

            // --- Elements for Edit Address Modal ---
            const editModal = document.getElementById('editAddressModal');
            const closeEditModalBtn = document.getElementById('closeEditModal');
            const cancelEditModalBtn = document.getElementById('cancelEditModal');
            const editAddressForm = document.getElementById('editAddressForm');
            const editAddressBtns = document.querySelectorAll('.edit-address-btn');

            // Form fields for Edit Modal
            const editRecipientName = document.getElementById('edit_recipient_name');
            const editPhoneNumber = document.getElementById('edit_phone_number');
            const editStreetAddress = document.getElementById('edit_street_address');
            const editCity = document.getElementById('edit_city');
            const editProvince = document.getElementById('edit_province');
            const editUrbanVillage = document.getElementById('edit_urban_village');
            const editSubdistrict = document.getElementById('edit_subdistrict');
            const editPostalCode = document.getElementById('edit_postal_code');
            const editLabelHome = document.getElementById('edit_label_home');
            const editLabelWork = document.getElementById('edit_label_work');

            // --- Elements for Add New Address Modal ---
            const addAddressBtn = document.getElementById('addAddressBtn');
            const addAddressModal = document.getElementById('addAddressModal');
            const closeAddModalBtn = document.getElementById('closeAddModal');
            const cancelAddModalBtn = document.getElementById('cancelAddModal');
            const addAddressForm = document.getElementById('addAddressForm');

            // Function to reset form errors
            function clearValidationErrors(formElement) {
                formElement.querySelectorAll('p.text-red-500').forEach(p => p.remove());
                formElement.querySelectorAll('.border-red-500').forEach(input => {
                    input.classList.remove('border-red-500');
                });
            }

            // Function to reset all form fields
            function resetForm(formElement) {
                formElement.reset(); // Resets all form fields
                clearValidationErrors(formElement); // Clear error styles
            }

            // Event listener for "Add New Address" button
            if (addAddressBtn) {
                addAddressBtn.addEventListener('click', function() {
                    console.log('Add New Address button clicked!');
                    resetForm(addAddressForm); // Reset form when modal is opened manually
                    if (addAddressModal) {
                        addAddressModal.classList.remove('hidden');
                        console.log('Add Address Modal should now be visible.');
                    } else {
                        console.error('Error: addAddressModal element is null.');
                    }
                });
            }

            // Event listener for close button (X) on Add Modal
            if (closeAddModalBtn) {
                closeAddModalBtn.addEventListener('click', () => {
                    console.log('Close Add Modal button (X) clicked.');
                    if (addAddressModal) addAddressModal.classList.add('hidden');
                    resetForm(addAddressForm); // Reset form on close
                });
            }

            // Event listener for "Cancel" button on Add Modal
            if (cancelAddModalBtn) {
                cancelAddModalBtn.addEventListener('click', () => {
                    console.log('Cancel Add Modal button clicked.');
                    if (addAddressModal) addAddressModal.classList.add('hidden');
                    resetForm(addAddressForm); // Reset form on cancel
                });
            }

            // Logic to open Add Modal if validation failed for 'store'
            @if (session('show_add_modal') && $errors->any() && session('old_input_from_store'))
                console.log('Session show_add_modal is true, opening Add Modal.');
                addAddressModal.classList.remove('hidden');
                // Re-populate old input for add form (already handled by old() in blade)
                // Need to manually re-check radio buttons and checkbox for old() values
                if (document.getElementById('add_label_home').value == "{{ old('label') }}") {
                    document.getElementById('add_label_home').checked = true;
                } else if (document.getElementById('add_label_work').value == "{{ old('label') }}") {
                    document.getElementById('add_label_work').checked = true;
                }
            @endif

            // Event listeners for "Edit" buttons
            editAddressBtns.forEach(button => {
                button.addEventListener('click', function() {
                    console.log('Edit button clicked!');
                    clearValidationErrors(editAddressForm); // Clear previous errors on opening
                    const addressDiv = this.closest('[data-id]');
                    const id = addressDiv.dataset.id;
                    const recipientName = addressDiv.dataset.recipientName;
                    const phoneNumber = addressDiv.dataset.phoneNumber;
                    const streetAddress = addressDiv.dataset.streetAddress;
                    const city = addressDiv.dataset.city;
                    const province = addressDiv.dataset.province;
                    const urbanVillage = addressDiv.dataset.urbanVillage;
                    const subdistrict = addressDiv.dataset.subdistrict;
                    const postalCode = addressDiv.dataset.postalCode
                    const label = addressDiv.dataset.label;
                    const isDefault = addressDiv.dataset.isDefault === 'true'; // Convert to boolean

                    console.log(`Editing Address ID: ${id}`);

                    // Fill the form fields
                    editRecipientName.value = recipientName;
                    editPhoneNumber.value = phoneNumber;
                    editStreetAddress.value = streetAddress;
                    editCity.value = city;
                    editProvince.value = province;
                    editUrbanVillage.value = urbanVillage;
                    editSubdistrict.value = subdistrict;
                    editPostalCode.value = postalCode;

                    // Set radio button for label
                    if (label === 'Home') {
                        editLabelHome.checked = true;
                    } else if (label === 'Work') {
                        editLabelWork.checked = true;
                    } else {
                        // If label is not Home or Work, uncheck both (or handle custom labels)
                        editLabelHome.checked = false;
                        editLabelWork.checked = false;
                    }

                    // Set the form action dynamically
                    editAddressForm.action =
                    `/addresses/${id}`; // Adjust based on your route structure

                    if (editModal) {
                        editModal.classList.remove('hidden');
                        console.log('Edit Address Modal should now be visible.');
                    } else {
                        console.error('Error: editAddressModal element is null.');
                    }
                });
            });

            // Event listener for close button (X) on Edit Modal
            if (closeEditModalBtn) {
                closeEditModalBtn.addEventListener('click', () => {
                    console.log('Close Edit Modal button (X) clicked.');
                    if (editModal) editModal.classList.add('hidden');
                    resetForm(editAddressForm); // Reset form on close
                });
            }

            // Event listener for "Cancel" button on Edit Modal
            if (cancelEditModalBtn) {
                cancelEditModalBtn.addEventListener('click', () => {
                    console.log('Cancel Edit Modal button clicked.');
                    if (editModal) editModal.classList.add('hidden');
                    resetForm(editAddressForm); // Reset form on cancel
                });
            }

            // Logic to open Edit Modal if validation failed for 'update'
            @if (session('show_edit_modal_id') && $errors->any())
                console.log('Session show_edit_modal_id is set, opening Edit Modal.');
                const addressIdToOpen = {{ session('show_edit_modal_id') }};
                const oldEditData = @json(session('old_edit_data')); // Get old input flashed from controller

                if (editModal) {
                    editModal.classList.remove('hidden');

                    // Repopulate form with old input data
                    editRecipientName.value = oldEditData.recipient_name || '';
                    editPhoneNumber.value = oldEditData.phone_number || '';
                    editStreetAddress.value = oldEditData.street_address || '';
                    editCity.value = oldEditData.city || '';
                    editProvince.value = oldEditData.province || '';
                    editUrbanVillage.value = oldEditData.urban_village || '';
                    editSubdistrict.value = oldEditData.subdistrict || '';
                    editPostalCode.value = oldEditData.postal_code || '';

                    // Re-check label radio buttons
                    if (oldEditData.label === 'Home') {
                        editLabelHome.checked = true;
                    } else if (oldEditData.label === 'Work') {
                        editLabelWork.checked = true;
                    } else {
                        editLabelHome.checked = false;
                        editLabelWork.checked = false;
                    }

                    // Set the form action for the specific ID that failed validation
                    editAddressForm.action = `/addresses/${addressIdToOpen}`;
                }
            @endif
        });
    </script>

</x-layout>
