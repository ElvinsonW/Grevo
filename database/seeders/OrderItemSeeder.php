<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\ProductVariant as Variant;
use App\Models\Product;
use App\Models\ProductImage as Image;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Order ORD123456789 with 2 items
        // Order ORD123456789 with 2 items
        // Order 1 with 2 items
        OrderItem::create([
            'order_id' => 1,
            'variant_id' => 1,
            'quantity' => 2,
            'price' => Variant::find(1)->price * 2,
        ]);
        
        OrderItem::create([
            'order_id' => 1,
            'variant_id' => 9,
            'quantity' => 1,
            'price' => Variant::find(9)->price * 1,
        ]);

        // Order 2 with 3 items
        OrderItem::create([
            'order_id' => 2,
            'variant_id' => 13,
            'quantity' => 1,
            'price' => Variant::find(13)->price * 1,
        ]);
        OrderItem::create([
            'order_id' => 2,
            'variant_id' => 12,
            'quantity' => 2,
            'price' => Variant::find(12)->price * 2,
        ]);
        OrderItem::create([
            'order_id' => 2,
            'variant_id' => 27,
            'quantity' => 1,
            'price' => Variant::find(27)->price * 1,
        ]);

        // Order 3 with 1 item
        OrderItem::create([
            'order_id' => 3,
            'variant_id' => 10,
            'quantity' => 1,
            'price' => Variant::find(10)->price * 1,
        ]);
        
    }
}