<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $primaryKey = 'batchid';
    
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'organization_id');
    }

    protected $fillable = [
        'organization_id',
        'dateofactivity',
        'treesplanted',
        'startdate',
        'enddate',
        'batchproof'
    ];
}
