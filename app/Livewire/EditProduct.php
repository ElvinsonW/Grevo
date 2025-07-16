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

    // Step 1
    public $name, $category, $description, $material, $weight, $certificate, $process;
    public $images = [], $imagesUpload = [];

    // Step 2
    public $newSize = '', $newColor = '';
    public $sizes = [], $colors = [];
    public $hasVariants = true;

    // Step 3
    public $variantData = [];        // for variants
    public $singleStock = '', $singlePrice = '', $singleSku = ''; // for simple product

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

        // Prepare image preview
        foreach ($product->product_images as $img) {
            $this->images[] = ['image' => $img->image];
        }

        // Step 2 & 3
        $firstVariant = $product->product_variants->first();

        if ($firstVariant && !$firstVariant->size && !$firstVariant->color) {
            $this->hasVariants = false;
            $this->singleStock = $firstVariant->stock;
            $this->singlePrice = $firstVariant->price;
            $this->singleSku = $firstVariant->sku;
        } else {
            $this->hasVariants = true;
            $this->sizes = $product->product_variants->pluck('size.name')->unique()->filter()->values()->toArray();
            $this->colors = $product->product_variants->pluck('color.name')->unique()->filter()->values()->toArray();

            foreach ($product->product_variants as $variant) {
                $size = optional($variant->size)->name;
                $color = optional($variant->color)->name;
                $size = $size ?: '_';
                $color = $color ?: '_';
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
        $existing = $this->variantData;
        $newVariantData = [];

        $sizes = count($this->sizes) > 0 ? $this->sizes : ['_'];
        $colors = count($this->colors) > 0 ? $this->colors : ['_'];

        foreach ($sizes as $size) {
            foreach ($colors as $color) {
                $key = "$size|$color";
                $newVariantData[$key] = $existing[$key] ?? [
                    'stock' => '',
                    'price' => '',
                    'sku' => ''
                ];
            }
        }
        $this->variantData = $newVariantData;
    }

    public function nextStep()
    {
        if (!$this->validateStep()) return;
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

            $hasUploadedImage = collect($this->images)->contains(function ($img) {
                return isset($img['temporary']) || isset($img['image']);
            });

            if (!$hasUploadedImage) {
                $this->addError('imagesUpload', 'Please upload at least one product image.');
            }
        }

        if ($this->step === 2 && $this->hasVariants) {
            if (count($this->sizes) === 0 && count($this->colors) === 0) {
                $this->addError('sizes', 'Please add at least one size or color.');
                $this->addError('colors', 'Please add at least one size or color.');
                return false;
            }
        }

        return !$this->getErrorBag()->isNotEmpty();
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
            'certificate' => 'nullable|string',
        ]);

        if ($this->hasVariants) {
            $this->validate([
                'variantData.*.stock' => 'required|numeric|min:0',
                'variantData.*.price' => 'required|numeric|min:0',
                'variantData.*.sku' => 'required'
            ]);
        } else {
            $this->validate([
                'singleStock' => 'required|numeric|min:0',
                'singlePrice' => 'required|numeric|min:0',
                'singleSku' => 'required'
            ]);
        }

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

            ProductVariant::where('product_id', $product->id)->delete();
            ProductImage::where('product_id', $product->id)->delete();

            // Images
            foreach ($this->images as $img) {
                $path = isset($img['temporary'])
                    ? $img['temporary']->store('products', 'public')
                    : $img['image'];

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }

            // Variants
            if ($this->hasVariants) {
                foreach ($this->variantData as $key => $data) {
                    [$size, $color] = explode('|', $key);

                    $size = $size === '_' ? null : $size;
                    $color = $color === '_' ? null : $color;

                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'stock' => $data['stock'],
                        'price' => $data['price'],
                        'sku' => $data['sku']
                    ]);

                    if ($size) {
                        $sizeModel = Size::create([
                            'product_variant_id' => $variant->id,
                            'name' => $size
                        ]);
                    }

                    if ($color) {
                        Color::create([
                            'product_variant_id' => $variant->id,
                            'name' => $color,
                            'size_id' => $sizeModel?->id
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

        session()->flash('message', 'Product updated successfully!');
        return redirect()->route('admin.products.list');
    }

    public function render()
    {
        return view('livewire.edit-product', [
            'categories' => ProductCategory::all()
        ]);
    }
}
