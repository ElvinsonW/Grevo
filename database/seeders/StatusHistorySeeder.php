<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusHistory;

class StatusHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Order 1: 5 statuses, each 2 days apart
        StatusHistory::create([
            'order_id' => 1,
            'status' => 'ORDER PLACED',
            'changed_at' => now()->subDays(10)->subMinutes(300),
        ]);
        StatusHistory::create([
            'order_id' => 1,
            'status' => 'ORDER SHIPPED',
            'changed_at' => now()->subDays(7)->subMinutes(200),
        ]);
        StatusHistory::create([
            'order_id' => 1,
            'status' => 'ORDER ARRIVED',
            'changed_at' => now()->subDays(5)->subMinutes(150),
        ]);
        StatusHistory::create([
            'order_id' => 1,
            'status' => 'ORDER RECEIVED',
            'changed_at' => now()->subDays(3)->subMinutes(100),
        ]);
        StatusHistory::create([
            'order_id' => 1,
            'status' => 'ORDER COMPLETED',
            'changed_at' => now()->subDays(1)->subMinutes(50),
        ]);

         // Order 2: up to ORDER SHIPPED, 2 days apart
        StatusHistory::create([
            'order_id' => 2,
            'status' => 'ORDER PLACED',
            'changed_at' => now()->subDays(5)->subMinutes(120), 
        ]);
        StatusHistory::create([
            'order_id' => 2,
            'status' => 'ORDER SHIPPED',
            'changed_at' => now()->subDays(2)->subMinutes(45),
        ]);

        // Order 3: only ORDER PLACED
        StatusHistory::create([
            'order_id' => 3,
            'status' => 'ORDER PLACED',
            'changed_at' => now()->subDays(2)->subMinutes(20),
        ]);
    }
}
