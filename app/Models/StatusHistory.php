<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'changed_at',
    ];

    protected $with = ['order'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
