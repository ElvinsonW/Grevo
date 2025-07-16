<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    //
    protected $primaryKey = 'treeid';  

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'organization_id');
    }
    
    protected $fillable =[
        'treename',
        'treecategory',
        'treedesc',
        'treelife',
        'treeprice',
        'treephoto',
        'organization_id'
    ];
    protected $with = ['organization'];
}
