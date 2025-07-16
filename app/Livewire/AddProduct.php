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

    // Step 1
    public $name, $category, $description, $material, $weight, $certificate, $process;
    public $images = [];
    public $imagesUpload = [];

    // Step 2
    public $newSize = '', $newColor = '';
    public $sizes = [], $colors = [];
    public $hasVariants = true;

    // Step 3
    public $variantData = [];
    public $singleStock = '', $singlePrice = '', $singleSku = '';

    public function updatedImagesUpload()
    {
        if (is_array($this->imagesUpload)) {
            foreach ($this->imagesUpload as $img) {
                if (count($this->images) < 8) {
                    $this->images[] = $img;
                }
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
        $this->variantData = [];

        if (!empty($this->sizes) && !empty($this->colors)) {
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
        } elseif (!empty($this->sizes)) {
            foreach ($this->sizes as $size) {
                $key = "$size|";
                $this->variantData[$key] = [
                    'stock' => '',
                    'price' => '',
                    'sku' => ''
                ];
            }
        } elseif (!empty($this->colors)) {
            foreach ($this->colors as $color) {
                $key = "|$color";
                $this->variantData[$key] = [
                    'stock' => '',
                    'price' => '',
                    'sku' => ''
                ];
            }
        }
    }


    public function updatedHasVariants($value)
    {
        if (!$value) {
            $this->sizes = [];
            $this->colors = [];
            $this->variantData = [];

            if (empty($this->singleSku) && !empty($this->name)) {
                $this->singleSku = strtoupper(Str::slug($this->name));
            }
        }
    }

    public function updatedName()
    {
        if (!$this->hasVariants && empty($this->singleSku)) {
            $this->singleSku = strtoupper(Str::slug($this->name));
        }
    }

    public function nextStep()
    {
        if (!$this->validateStep()) return;
        $this->step++;

        if ($this->step === 2 && !$this->hasVariants) {
            // Reset size/color data
            $this->sizes = [];
            $this->colors = [];
            $this->variantData = [];
        }

        if ($this->step === 3 && $this->hasVariants && empty($this->variantData)) {
            $this->generateVariants();
        }
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

            if (count($this->images) === 0) {
                $this->addError('imagesUpload', 'Please upload at least one product image.');
            }
        }


        if ($this->step === 2 && $this->hasVariants) {
            $hasSize = is_array($this->sizes) && count($this->sizes) > 0;
            $hasColor = is_array($this->colors) && count($this->colors) > 0;

            if (!$hasSize && !$hasColor) {
                $this->addError('sizes', 'Please add at least one size or color.');
                $this->addError('colors', 'Please add at least one size or color.');
                return false;
            }

            $this->validate([
                'sizes' => 'array',
                'colors' => 'array'
            ]);
        }

        return !$this->getErrorBag()->isNotEmpty();
    }

    public function store()
    {
        if ($this->hasVariants) {
            $this->validate([
                'variantData.*.stock' => 'required|numeric|min:0',
                'variantData.*.price' => 'required|numeric|min:0',
                'variantData.*.sku' => 'required|unique:product_variants,sku'
            ]);
        } else {
            $this->validate([
                'singleStock' => 'required|numeric|min:0',
                'singlePrice' => 'required|numeric|min:0',
                'singleSku' => 'required|unique:product_variants,sku'
            ]);
        }

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

            if ($this->hasVariants) {
                foreach ($this->variantData as $key => $data) {
                [$sizeName, $colorName] = array_pad(explode('|', $key), 2, null);

                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'stock' => $data['stock'],
                        'price' => $data['price'],
                        'sku' => $data['sku']
                    ]);

                if (!empty($sizeName)) {
                    $sizeModel = Size::create([
                        'product_variant_id' => $variant->id,
                        'name' => $sizeName
                    ]);
                }

                if (!empty($colorName)) {
                    Color::create([
                        'product_variant_id' => $variant->id,
                        'size_id' => $sizeModel?->id, // only if exists
                        'name' => $colorName,
                    ]);
                }
            }
            } else {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'stock' => $this->singleStock,
                    'price' => $this->singlePrice,
                    'sku' => $this->singleSku
                ]);
            }
        });

        session()->flash('message', 'Product added successfully!');
        return redirect()->route('admin.products.list');
    }

    public function render()
    {
        return view('livewire.add-product', [
            'categories' => ProductCategory::all()
        ]);
    }
}
