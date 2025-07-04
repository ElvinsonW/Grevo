<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EditProduct extends Component
{
    use WithFileUploads;

    public $productId;
    public $step = 1;

    // Step 1 fields
    public $name, $category, $description, $material, $weight, $certificate, $process;
    public $images = [];
    public $imagesUpload = [];

    // Step 2 fields
    public $newSize = '', $newColor = '';
    public $sizes = [], $colors = [];

    // Step 3 fields
    public $variantData = [];

    public function mount($productId)
    {
        $product = Product::with('product_images', 'product_variants.size', 'product_variants.color')->findOrFail($productId);
        $this->productId = $product->id;

        // Step 1
        $this->name = $product->name;
        $this->category = $product->product_category_id;
        $this->description = $product->description;
        $this->material = $product->material;
        $this->weight = $product->weight;
        $this->certificate = $product->certification;
        $this->process = $product->process;
        $this->images = $product->product_images->toArray();

        // Step 2
        $this->sizes = $product->product_variants->pluck('size.name')->unique()->values()->toArray();
        $this->colors = $product->product_variants->pluck('color.name')->unique()->values()->toArray();

        // Step 3
        foreach ($product->product_variants as $variant) {
            $size = optional($variant->size)->name;
            $color = optional($variant->color)->name;

            if ($size && $color) {
                $key = "$size|$color";
                $this->variantData[$key] = [
                    'stock' => $variant->stock,
                    'price' => $variant->price,
                    'sku' => $variant->sku,
                ];
            }
        }
    }


    public function updatedImagesUpload()
    {
        foreach ($this->imagesUpload as $img) {
            if (count($this->images) < 8) {
                $this->images[] = ['temporary' => $img];
            }
        }

        $this->reset('imagesUpload');
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function addSize()
    {
        $size = trim($this->newSize);
        if ($size && !in_array($size, $this->sizes)) {
            $this->sizes[] = $size;
            $this->generateVariants();
        }
        $this->newSize = '';
    }

    public function removeSize($index)
    {
        unset($this->sizes[$index]);
        $this->sizes = array_values($this->sizes);
        $this->generateVariants();
    }

    public function addColor()
    {
        $color = trim($this->newColor);
        if ($color && !in_array($color, $this->colors)) {
            $this->colors[] = $color;
            $this->generateVariants();
        }
        $this->newColor = '';
    }

    public function removeColor($index)
    {
        unset($this->colors[$index]);
        $this->colors = array_values($this->colors);
        $this->generateVariants();
    }

public function generateVariants()
{
    $existing = $this->variantData; // Keep previous data
    $newVariantData = [];

    foreach ($this->sizes as $size) {
        foreach ($this->colors as $color) {
            $key = "$size|$color";
            // Use existing data if available, otherwise empty default
            $newVariantData[$key] = $existing[$key] ?? [
                'stock' => '',
                'price' => '',
                'sku' => ''
            ];
        }
    }

    $this->variantData = $newVariantData;
}

    public function updateProduct()
    {
        $this->validate([
            'name' => 'required',
            'category' => 'required|exists:product_categories,id',
            'description' => 'required',
            'material' => 'required',
            'weight' => 'required|numeric',
            'process' => 'required|string',
            'variantData.*.stock' => 'required|numeric|min:0',
            'variantData.*.price' => 'required|numeric|min:0',
            'variantData.*.sku' => 'required'
        ]);

        DB::transaction(function () {
            $product = Product::findOrFail($this->productId);
            $product->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name . '-' . Str::random(6)),
                'product_category_id' => $this->category,
                'description' => $this->description,
                'material' => $this->material,
                'weight' => $this->weight,
                'certification' => $this->certificate,
                'process' => $this->process,
            ]);

            // Optional: delete old variants/images
            ProductVariant::where('product_id', $product->id)->delete();
            ProductImage::where('product_id', $product->id)->delete();

            foreach ($this->images as $image) {
                $path = isset($image['temporary']) ? $image['temporary']->store('products', 'public') : $image['image'];
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }

            foreach ($this->variantData as $key => $data) {
                [$size, $color] = explode('|', $key);

                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'stock' => $data['stock'],
                    'price' => $data['price'],
                    'sku' => $data['sku']
                ]);

                Size::create([
                    'product_variant_id' => $variant->id,
                    'name' => $size
                ]);

                Color::create([
                    'product_variant_id' => $variant->id,
                    'name' => $color
                ]);
            }
        });

        session()->flash('message', 'Product updated successfully!');
        return redirect()->route('products.list');
    }

    public function render()
    {
        return view('livewire.edit-product', [
            'categories' => ProductCategory::all()
        ]);
    }
       public function nextStep()
    {
        $this->validateStep();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function validateStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'name' => 'required',
                'category' => 'required|exists:product_categories,id',
                'description' => 'required',
                'material' => 'required',
                'weight' => 'required|numeric',
                'certificate' => 'nullable|string',
                'process' => 'required|string',
                'images.*.temporary' => 'nullable|image|max:2048'
            ]);
        }

        if ($this->step === 2) {
            $this->validate([
                'sizes' => 'required|array|min:1',
                'colors' => 'required|array|min:1'
            ]);
        }
    }

}
