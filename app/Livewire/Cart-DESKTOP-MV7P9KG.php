<?php

namespace App\Livewire;

use App\Models\Cart as CartModel;
use Livewire\Component;

class Cart extends Component
{
    public $cartProduct;
    public $selectedProduct;
    public $selectAll;
    
    public function mount()
    {
        $this->refreshCart();
        $this->selectedProduct = [];
        $this->selectAll = false;
    }

    public function updatedSelectedProduct($value)
    {
        
    }

    public function refreshCart()
    {
        $this->cartProduct = CartModel::where('user_id', auth()->user()->id)
            ->with('product_variant.product.product_images', 'product_variant.color', 'product_variant.size')
            ->get();
    }

    public function increment($id)
    {
        $cart = CartModel::findOrFail($id);
        if($cart->product_variant->stock != $cart->amount){
            $cart->amount++;
            $cart->save();
            $this->refreshCart();
        }
    }

    public function decrement($id)
    {
        $cart = CartModel::findOrFail($id);
        if ($cart->amount > 1) {
            $cart->amount--;
            $cart->save();
            $this->refreshCart();
        }
    }

    public function delete($id)
    {
        $product = CartModel::findOrFail($id);
        $product->delete();

        $this->selectedProduct = array_values(array_diff($this->selectedProduct, [$id]));

        $this->refreshCart();
    }

    public function getTotalPriceProperty()
    {
        return 
            CartModel::whereIn('id', $this->selectedProduct)
                ->get()
                ->sum(function ($item) {
                    return $item->product_variant->price * $item->amount;
                });
    }

    public function checkout()
    {
        return redirect()->route('checkout', [
            'carts' => $this->selectedProduct
        ]);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedProduct = $this->cartProduct->pluck('id')->toArray();
        } else {
            $this->selectedProduct = [];
        }
    }

    public function getSelectAllProperty()
    {
        return count($this->selectedProduct) === count($this->cartProduct);
    }

    public function render()
    {
        return view('livewire.cart');
    }
}