<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Batch;
use App\Models\Organization;
class BatchSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::first();
        //
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        Batch::create([
            'organization_id' => $org->organization_id,
            'startdate' => '2025-06-06',
            'enddate' => '2025-06-26',
            'dateofactivity' => '2025-06-06',
            'batchproof' => 'batchproof/openmouth.png',
            'treesplanted' => 50
        ]);
        
    }
}
