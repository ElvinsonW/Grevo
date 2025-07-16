<div id="editAddressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-[0.5vw] p-[2vw] shadow-lg w-[40vw] max-h-[90vh] overflow-y-auto relative">
        {{-- Close Button --}}
        <button id="closeModal" class="absolute top-[1vw] right-[1vw] text-gray-500 hover:text-gray-700 text-[1.5vw]">
            &times;
        </button>

        <h2 class="text-[1.8vw] font-bold mb-[2vw]">Edit Address</h2>

        {{-- Form Edit Address --}}
        <form id="editAddressForm" method="POST">
            @csrf
            @method('PUT') {{-- Penting: Menggunakan PUT untuk update --}}

            <div class="grid grid-cols-2 gap-[1.5vw] mb-[1.5vw]">
                <div>
                    <label for="edit_recipient_name" class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Full Name</label>
                    <input type="text" name="recipient_name" id="edit_recipient_name" class="w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500" required>
                    @error('recipient_name')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="edit_phone_number" class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Phone Number</label>
                    <input type="text" name="phone_number" id="edit_phone_number" class="w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500" required>
                    @error('phone_number')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-[1.5vw]">
                <label for="edit_province" class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Province</label>
                <input type="text" name="province" id="edit_province" class="w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500" required>
                @error('province')
                    <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-[1.5vw] mb-[1.5vw]">
                <div>
                    <label for="edit_city" class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">City</label>
                    <input type="text" name="city" id="edit_city" class="w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500" required>
                    @error('city')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="edit_subdistrict" class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Subdistrict (Kecamatan)</label>
                    <input type="text" name="subdistrict" id="edit_subdistrict" class="w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500">
                    @error('subdistrict')
                        <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-[1.5vw]">
                <label for="edit_urban_village" class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Urban Village (Kelurahan/Desa)</label>
                <input type="text" name="urban_village" id="edit_urban_village" class="w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500">
                @error('urban_village')
                    <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-[1.5vw]">
                <label for="edit_street_address" class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Street Name, Building, House Number</label>
                <textarea name="street_address" id="edit_street_address" rows="3" class="w-full border border-gray-300 rounded-[0.3vw] p-[0.75vw] text-[0.9vw] focus:ring-blue-500 focus:border-blue-500" required></textarea>
                @error('street_address')
                    <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-[1.5vw]">
                <label class="block text-[0.9vw] font-medium text-gray-700 mb-[0.5vw]">Label As</label>
                <div class="flex gap-[1vw]">
                    <label class="inline-flex items-center">
                        <input type="radio" name="edit_label" value="Home" class="form-radio text-[var(--color-green-3)]" id="label_home">
                        <span class="ml-[0.5vw] text-[0.9vw] text-gray-700 border border-gray-300 px-[1vw] py-[0.5vw] rounded-[0.3vw] cursor-pointer has-[:checked]:bg-[var(--color-green-1)] has-[:checked]:border-[var(--color-green-3)] has-[:checked]:text-[var(--color-green-3)]">Home</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="edit_label" value="Work" class="form-radio text-[var(--color-green-3)]" id="label_work">
                        <span class="ml-[0.5vw] text-[0.9vw] text-gray-700 border border-gray-300 px-[1vw] py-[0.5vw] rounded-[0.3vw] cursor-pointer has-[:checked]:bg-[var(--color-green-1)] has-[:checked]:border-[var(--color-green-3)] has-[:checked]:text-[var(--color-green-3)]">Work</span>
                    </label>
                </div>
                @error('label')
                    <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-[2vw]">
                <label class="inline-flex items-center text-[0.9vw] text-gray-700">
                    <input type="checkbox" name="is_default" id="edit_is_default" class="form-checkbox text-[var(--color-green-3)] rounded">
                    <span class="ml-[0.5vw]">Set as default address</span>
                </label>
                @error('is_default')
                    <p class="text-red-500 text-[0.8vw] mt-[0.25vw]">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-[1vw]">
                <button type="button" id="cancelModal" class="px-[1.5vw] py-[0.75vw] text-[1vw] border border-gray-300 rounded-[0.3vw] text-gray-700 hover:bg-gray-100">Cancel</button>
                <button type="submit" class="px-[1.5vw] py-[0.75vw] text-[1vw] rounded-[0.3vw] bg-[var(--color-orange-1)] text-white hover:bg-[var(--color-orange-2)]">Submit</button>
            </div>
        </form>
    </div>
</div>