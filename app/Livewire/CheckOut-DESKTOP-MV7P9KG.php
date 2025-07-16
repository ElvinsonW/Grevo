<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Cart as CartModel;
use App\Services\RajaOngkirService;
use Livewire\Component;

class CheckOut extends Component
{
    public $selectedProductIds;
    public $cartProduct;
    public $address;
    public $addressId;
    public $recipientName;
    public $shippingCost = 0;

    public function mount($cartIds)
    {
        $this->address = Address::where('user_id',auth()->user()->id)->where('is_default', true)->firstOrFail();
        $this->addressId = $this->address->rajaOngkirId;
        $this->recipientName = $this->address->recipient_name;
        $this->selectedProductIds = $cartIds;
        $this->refreshCart();
        $this->calculateShippingCost();
    }

    public function refreshCart()
    {
        $this->cartProduct = CartModel::whereIn('id',$this->selectedProductIds)->get();
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

        $this->selectedProductIds = array_values(array_diff($this->selectedProductIds, [$id]));

        $this->refreshCart();
    }

    public function getSubTotalPriceProperty()
    {
        return 
            CartModel::whereIn('id', $this->selectedProductIds)
                ->get()
                ->sum(function ($item) {
                    return $item->product_variant->price * $item->amount;
                });
    }

    public function calculateWeight(){
        $totalWeight = 0;
        foreach($this->cartProduct as $cart){
            $totalWeight += $cart->product_variant->product->weight * $cart->amount;
        }
        
        return $totalWeight;
    }

    public function calculateShippingCost()
    {
        $rajaOngkir = new RajaOngkirService();
        $this->shippingCost = $rajaOngkir->calculateCost($this->address->rajaOngkirId, $this->calculateWeight());
    }

    public function changeAddressId($value)
    {
        $selectedAddress = auth()->user()->addresses->firstWhere('rajaOngkirId', $value);
        $this->recipientName = $selectedAddress?->recipient_name ?? '';
        $this->address = $selectedAddress;

        $this->calculateShippingCost();   
    }

    public function checkout()
    {
       return redirect()->route('checkout.payment', [
            'cartIds' => $this->selectedProductIds,
            'email' => auth()->user()->email,
            'name' => auth()->user()->name
        ]);
    }   

    public function render()
    {
        return view('livewire.check-out');
    }
}
