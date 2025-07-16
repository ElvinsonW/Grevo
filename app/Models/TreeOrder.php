<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tree_id',
        'amount',
        'total_price',
    ];
    protected $with = ['user', 'tree'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tree()
    {
        return $this->belongsTo(Tree::class, 'tree_id', 'treeid'); // 'tree_id' is FK on tree_orders, 'treeid' is PK on trees table
    }
}