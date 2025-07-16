<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\Tree;

class TreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $org = Organization::first();
        $org2 = Organization::skip(1)->first();
        $org3 = Organization::skip(2)->first();
        $org4 = Organization::skip(3)->first();
        $org5 = Organization::skip(4)->first();
        $org6 = Organization::skip(5)->first();
        Tree::create([
            'treename' => 'Mangrove',
            'treecategory' => 'Pine',
            'treedesc' => 'A wild tree has appeared!',
            'treelife' => 20,
            'treeprice' => 20.5,
            'treephoto' => 'treesphoto/close.png',
            'organization_id' => $org->organization_id
        ]);
        Tree::create([
            'treename' => 'Oak',
            'treecategory' => 'Deciduous',
            'treedesc' => 'A sturdy tree known for its strong wood.',
            'treelife' => 50,
            'treeprice' => 35.75,
            'treephoto' => 'treesphoto/oak.png',
            'organization_id' => $org2->organization_id
        ]);

        Tree::create([
            'treename' => 'Bamboo',
            'treecategory' => 'Grass',
            'treedesc' => 'Fast-growing and versatile plant.',
            'treelife' => 15,
            'treeprice' => 12.99,
            'treephoto' => 'treesphoto/bamboo.png',
            'organization_id' => $org->organization_id
        ]);

        Tree::create([
            'treename' => 'Cedar',
            'treecategory' => 'Coniferous',
            'treedesc' => 'Evergreen with aromatic wood.',
            'treelife' => 40,
            'treeprice' => 28.50,
            'treephoto' => 'treesphoto/cedar.png',
            'organization_id' => $org3->organization_id
        ]);

        Tree::create([
            'treename' => 'Baobab',
            'treecategory' => 'Succulent',
            'treedesc' => 'Iconic tree with a thick trunk.',
            'treelife' => 100,
            'treeprice' => 45.00,
            'treephoto' => 'treesphoto/baobab.png',
            'organization_id' => $org4->organization_id
        ]);

        Tree::create([
            'treename' => 'Palm',
            'treecategory' => 'Tropical',
            'treedesc' => 'Tall and flexible tropical tree.',
            'treelife' => 30,
            'treeprice' => 22.25,
            'treephoto' => 'treesphoto/palm.png',
            'organization_id' => $org5->organization_id
        ]);

        Tree::create([
            'treename' => 'Acacia',
            'treecategory' => 'Savanna',
            'treedesc' => 'Thrives in arid environments.',
            'treelife' => 25,
            'treeprice' => 18.80,
            'treephoto' => 'treesphoto/acacia.png',
            'organization_id' => $org6->organization_id
        ]);

        Tree::create([
            'treename' => 'Maple',
            'treecategory' => 'Deciduous',
            'treedesc' => 'Known for vibrant autumn leaves.',
            'treelife' => 60,
            'treeprice' => 30.00,
            'treephoto' => 'treesphoto/maple.png',
            'organization_id' => $org6->organization_id
        ]);
    }
}
