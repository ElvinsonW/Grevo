<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Review;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = ["search", "category", "min_price", "max_price"];
        return view('User.product.products', [
            "products" => Product::withAvg('reviews', 'rate')->filter(request($filters))->paginate(12)->withQueryString(),
            "categories" => ProductCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    public function show(string $slug)
    {
        $product = Product::withAvg("reviews", "rate")->where("slug", $slug)->firstOrFail();
        $similarProduct = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->withAvg('reviews', 'rate')
            ->inRandomOrder()
            ->take(5)
            ->get();
        $reviews = Review::where("product_id",$product->id)->latest()->take(3)->get();
        return view("User.product.product-detail", [
            "product" => $product, 
            "similarProducts" => $similarProduct,
            "reviews" => $reviews
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showlist()
    {
        $query = Product::with(['product_category', 'product_images', 'product_variants']);
        if (request()->has('stock')) {
            $query->whereHas('product_variants', function ($q) {
                if (request('stock') === 'in') {
                    $q->where('stock', '>', 0);
                } elseif (request('stock') === 'out') {
                    $q->where('stock', '=', 0);
                }
            });
        }

        $products = $query->paginate(10);

        return view('Admin.Product.listproduct', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('Admin.Product.editproduct', compact('product'));
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
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.list')->with('message', 'Product deleted successfully.');
    }

    public function createSlug(string $name)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $name, ["unique" => true]);
        return $slug;
    }
}
