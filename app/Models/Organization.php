<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Organization extends Model
{
    protected $primaryKey = 'organization_id';  
    public $incrementing = true;
    protected $keyType = 'int';

    public function trees()
    {
        return $this->hasMany(Tree::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
    protected $fillable =[
        'organization_name',
        'operational_address',
        'brief_description',
        'coverage_region',
        'official_contact_info',
        'organization_logo',
        'types_of_tree_planted',
        'existing_partner_or_sponsor',
        'organization_status'
    ];
}
