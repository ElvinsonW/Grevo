<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'order_id' => 'ORD123456789',
            'shipping' => 10000,
            'payment_method' => 'Credit Card',
            'user_id' => 2,
        ]);

        Order::create([
            'order_id' => 'ORD123456790',
            'shipping' => 15000,
            'payment_method' => 'Bank Transfer',
            'user_id' => 2,
        ]);

        Order::create([
            'order_id' => 'ORD123456791',
            'shipping' => 8000,
            'payment_method' => 'Cash',
            'user_id' => 2,
        ]);
    }
}
