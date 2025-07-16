<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();
        $totalReview = $reviews->count();
                
        if ($totalReview > 1000){
            $totalReview = (string)round($totalReview / 1000, 1) . 'k';
        }
        return view('User.review.index-review', [
            'reviews' => $reviews,
            'totalReview' => $totalReview,
            'avgRate' => round(Review::avg('rate'),1)
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Order $order)
    {
        $product_variants_id = $order->items->pluck('variant_id')->toArray();
        $product_variants = ProductVariant::wherein('id', $product_variants_id)->get();
        return view('User.review.create-review', ["product_variants" => $product_variants]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reviewData = $request->validate([
            'rate' => ['required', 'between:1,5'],
            'description' => ['nullable'],
            
        ]);

        DB::beginTransaction();
        
        
        try{
            $reviewData['user_id'] = 1;
            $review = Review::create($reviewData);

            $request->validate([
                'images' => ['array'],
                'images.*' => ['image', 'mimes:png,jpg,jpeg,gif,svg', 'max:1024']
            ]);
            
            if($request->hasFile('images')){
                foreach($request->file('images') as $img){
                    ReviewImage::create([
                        'review_id' => $review->id,
                        'source' => $img->store('review-image')
                    ]);
                }
            }

            DB::commit();
            return redirect('/review')->with('reviewSuccess', 'Review is submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/');
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $product = Product::where("slug", $slug)->firstOrFail();
        $reviews = Review::where("product_id", $product->id)->get();
        $totalReview = $reviews->count();
                
        if ($totalReview > 1000){
            $totalReview = (string)round($totalReview / 1000, 1) . 'k';
        }
        return view('User.review.index-review', [
            'reviews' => $reviews,
            'totalReview' => $totalReview,
            'avgRate' => round($reviews->avg('rate'),1)
        ]);
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
