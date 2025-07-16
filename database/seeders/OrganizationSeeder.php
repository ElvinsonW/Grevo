<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        //
        Organization::create([
            'organization_name' => 'Green Earth Foundation',
            'operational_address' => '123 Forest Line',
            'brief_description' => 'No Profit Organization focused on reforestation',
            'coverage_region' => 'Asia Pacific',
            'official_contact_info' => 'contactgef@gmail.com',
            'organization_logo' => 'logos/AkademiCypto.png',
            'existing_partner_or_sponsor' => 'New',
            'organization_status' => 'Active'
        ]);
        Organization::create([
            'organization_name' => 'Blue Ocean Trust',
            'operational_address' => '456 Coastal Avenue',
            'brief_description' => 'Non-profit dedicated to marine conservation',
            'coverage_region' => 'Global',
            'official_contact_info' => 'info@blueocean.org',
            'organization_logo' => 'logos/MarineBlue.png',
            'existing_partner_or_sponsor' => 'Existing',
            'organization_status' => 'Active'
        ]);

        Organization::create([
            'organization_name' => 'Urban Renewal Collective',
            'operational_address' => '789 City Plaza',
            'brief_description' => 'Community-driven urban sustainability projects',
            'coverage_region' => 'North America',
            'official_contact_info' => 'urbanrenewal@outlook.com',
            'organization_logo' => 'logos/GreenPeace.png',
            'existing_partner_or_sponsor' => 'New',
            'organization_status' => 'Active'
        ]);

        Organization::create([
            'organization_name' => 'Desert Bloom Initiative',
            'operational_address' => '101 Arid Road',
            'brief_description' => 'Promoting agriculture in arid regions',
            'coverage_region' => 'Middle East',
            'official_contact_info' => 'desertbloom@yahoo.com',
            'organization_logo' => 'logos/DesertInitiative.png',
            'existing_partner_or_sponsor' => 'Existing',
            'organization_status' => 'Not Active'
        ]);

        Organization::create([
            'organization_name' => 'Mountain Guardians',
            'operational_address' => '321 Highland Trail',
            'brief_description' => 'Conservation of mountain ecosystems',
            'coverage_region' => 'South America',
            'official_contact_info' => 'mountainguard@gmail.com',
            'organization_logo' => 'logos/MountainGuardian.png',
            'existing_partner_or_sponsor' => 'New',
            'organization_status' => 'Not Active'
        ]);

        Organization::create([
            'organization_name' => 'Clean Rivers Network',
            'operational_address' => '654 Riverbank Drive',
            'brief_description' => 'Restoring polluted rivers and waterways',
            'coverage_region' => 'Europe',
            'official_contact_info' => 'cleanrivers@protonmail.com',
            'organization_logo' => 'logos/RiverNetwork.png',
            'existing_partner_or_sponsor' => 'Existing',
            'organization_status' => 'Not Active'
        ]);
    }
}
