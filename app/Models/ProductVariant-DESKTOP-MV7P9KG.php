<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariant extends Model
{
    use HasFactory;
    
    protected $fillable = ["product_id", "sku", "price", "stock"];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function carts(): HasMany {
        return $this->hasMany(Cart::class, "product_variant_id");
    }

    public function size(): HasOne {
        return $this->hasOne(Size::class, "product_variant_id");
    }   

    public function color(): HasOne {
        return $this->hasOne(Color::class, "product_variant_id");
    }   
}
