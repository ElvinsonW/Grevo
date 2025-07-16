<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->get();
        return view('User.cart.cart', ['carts' => $cart]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->color){
            $color = Color::find($request->color);
        } else if($request->size){
            $size = Size::find($request->size);
        }
        $product = Product::find($request->product_id);
        $product_variant_id = $color->product_variant->id ?? $size->product_variant->id ??  $product->product_variants->first()->id;
        $product_variant = ProductVariant::find($product_variant_id);
        
        $cart = Cart::where("product_variant_id", $product_variant_id)->where('user_id', auth()->user()->id)->first();

        if($cart){
            $cart->amount = $request->amount;
            $cart->total = $request->amount * $product_variant->price;
            $cart->save();
        } else {
            $cart1 = Cart::create([
                "user_id" => auth()->user()->id,
                "product_variant_id" => $product_variant_id,
                "amount" => $request->amount,
                "total" => $request->amount * $product_variant->price
            ]);
        }


        return redirect('/cart')->with("cartSuccess", "Product added successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
