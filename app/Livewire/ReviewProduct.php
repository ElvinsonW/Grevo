<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ReviewProduct extends Component
{
    use WithFileUploads;

    public $product_variants;
    public $selectedProduct;
    public $step = 1; 
    public $rate, $desc, $images = [];
    public $reviewedProducts = [];
    public $imagesUpload = [];
    public $endError = "";

    public function mount($product_variant_ids){
        $user = Auth::user();
        $this->product_variants = ProductVariant::whereIn('id', $product_variant_ids)->get();

        $this->reviewedProducts = Review::where('user_id', $user->id)
            ->pluck('product_id')
            ->toArray();
    }

    public function goReview(string $id){
        $this->step = 2;
        $variant = ProductVariant::find($id);
        $this->selectedProduct = $variant->product;   
        $this->endError = "";
    }

    public function saveReview()
    {
        $this->validate([
            'rate' => ['required','min:1','max:5'],
            'desc' => ['nullable'],
            'images.*' => ['image','max:1024'],
        ]);
        
        $review = $this->selectedProduct->reviews()->create([
            'user_id' => auth()->id(), 
            'rate' => $this->rate,
            'description' => $this->desc,
        ]);
        foreach ($this->images as $image) {
            $review->review_images()->create([
                'source' => $image->store('review-image')
            ]);
        }

        $this->reset(['rate', 'desc', 'images', 'selectedProduct']);
        $this->step = 1;

        $this->reviewedProducts = Review::where('user_id', auth()->id())
            ->pluck('product_id') 
            ->toArray();
    }

    public function endReview(){
        $currentProductIds = $this->product_variants->pluck('product_id')->unique()->toArray();

        $unreviewedProducts = array_diff($currentProductIds, $this->reviewedProducts);

        if(count($unreviewedProducts) != 0){
            $this->endError = "Please review all product first!";
        } else{
            $this->endError = "";
            Storage::deleteDirectory('livewire-tmp');
            return redirect()->route("profile.reviews");
        }

    }

    public function updatedImagesUpload()
    {
        $this->images = array_merge($this->images, $this->imagesUpload);

        $this->reset('imagesUpload');
    }

    public function removeImage($key)
    {
        unset($this->images[$key]);
        $this->images = array_values($this->images); 
    }

    
    public function render()
    {
        return view('livewire.review-product');
    }
}
