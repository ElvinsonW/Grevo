<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\Size;
use App\Models\User;
use App\Services\RajaOngkirService;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            OrganizationSeeder::class,
            TreeSeeder::class,
            BatchSeeder::class,
            AddressSeeder::class,
        ]);

        $variants = ProductVariant::all();

        foreach ($variants as $variant) {
            Cart::factory()->recycle(
                User::all()
            )->create([
                'product_variant_id' => $variant->id
            ]);
        }

        $products = Product::all();

        foreach ($products as $product) {
            Review::factory(rand(10, 30))->recycle([
                User::all()
            ])->create([
                'product_id' => $product->id,
            ])->each(
                function ($review) {
                    ReviewImage::factory(rand(1, 3))->create([
                        'review_id' => $review->id,
                        'source' => 'review-image/elvinson.jpg'
                    ]);
                }
            );
        }

        // Product::factory(30)->recycle(
        //     ProductCategory::all()
        // )->create()->each(
        //     function ($product) {
        //         ProductImage::factory(rand(1, 3))->create([
        //             'product_id' => $product->id,
        //             'image' => 'product-image/elvinson.jpg'
        //         ]);

        //         ProductVariant::factory(1)->create([
        //             'product_id' => $product->id
        //         ])->each(
        //             function ($variant) {
        //                 Size::factory()->create([
        //                     'product_variant_id' => $variant->id
        //                 ]);

        //                 Color::factory()->create([
        //                     'product_variant_id' => $variant->id
        //                 ]);

        //                 Cart::factory()->recycle(
        //                     User::all()
        //                 )->create([
        //                     'product_variant_id' => $variant->id
        //                 ]);
        //             }
        //         );


        //         Review::factory(10)->recycle([
        //             User::all()
        //         ])->create([
        //             'product_id' => $product->id
        //         ])->each(
        //             function ($review) {
        //                 ReviewImage::factory(rand(1, 3))->create([
        //                     'review_id' => $review->id,
        //                     'source' => 'review-image/elvinson.jpg'
        //                 ]);
        //             }
        //         );
        //     }
        // );

        $this->call([
            OrderSeeder::class,
            OrderItemSeeder::class,
            StatusHistorySeeder::class,
        ]);
    }
}
