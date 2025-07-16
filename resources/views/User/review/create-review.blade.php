<x-layout>
    @livewire('review-product', ["product_variant_ids" => $product_variants->pluck('id')])
    @livewireScripts
</x-layout>
