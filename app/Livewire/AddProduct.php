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

class AddProduct extends Component
{
    use WithFileUploads;

    public $step = 1;

    // Step 1 fields
    public $name, $category, $description, $material, $weight, $certificate, $process;
    public $images = [];              // Final images
    public $imagesUpload = [];        // Temporary input

    // Step 2 fields
    public $newSize = '', $newColor = '';
    public $sizes = [], $colors = [];

    // Step 3 fields
    public $variantData = [];

    // Step 1: Image Upload Handling
    public function updatedImagesUpload()
    {
        if (is_array($this->imagesUpload)) {
            foreach ($this->imagesUpload as $img) {
                if (count($this->images) < 8) {
                    $this->images[] = $img;
                }
            }
        }

        $this->reset('imagesUpload'); // Allow re-uploading
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    // Step 2: Add/Remove Sizes and Colors
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
        $this->variantData = [];

        foreach ($this->sizes as $size) {
            foreach ($this->colors as $color) {
                $key = "$size|$color";
                $this->variantData[$key] = [
                    'stock' => '',
                    'price' => '',
                    'sku' => ''
                ];
            }
        }
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
                'images.*' => 'image|max:2048'
            ]);
        }

        if ($this->step === 2) {
            $this->validate([
                'sizes' => 'required|array|min:1',
                'colors' => 'required|array|min:1'
            ]);
        }
    }

    public function store()
    {
        $this->validate([
            'variantData.*.stock' => 'required|numeric|min:0',
            'variantData.*.price' => 'required|numeric|min:0',
            'variantData.*.sku' => 'required|unique:product_variants,sku'
        ]);

        DB::transaction(function () {
            $product = Product::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name . '-' . Str::random(6)),
                'product_category_id' => $this->category,
                'description' => $this->description,
                'material' => $this->material,
                'weight' => $this->weight,
                'certification' => $this->certificate,
                'process' => $this->process,
                'sold' => 0
            ]);

            foreach ($this->images as $image) {
                $path = $image->store('products', 'public');
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

        session()->flash('message', 'Product added successfully!');
        return redirect()->route('products.list');
    }

    public function render()
    {
        return view('livewire.add-product', [
            'categories' => ProductCategory::all()
        ]);
    }
}
