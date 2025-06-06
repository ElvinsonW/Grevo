<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable = ["name", "slug"];

    public function product(): HasMany {
        return $this->hasMany(Product::class, "product_category_id");
    }
}
