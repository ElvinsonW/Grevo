<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Size extends Model
{
    use HasFactory;
    protected $fillable = ["product_variant_id", "name"];
    protected $with = ['product_variant'];

    public function product_variant(): BelongsTo{
        return $this->belongsTo(ProductVariant::class, "product_variant_id");
    }
}
