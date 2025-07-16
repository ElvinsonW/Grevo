<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "product_id", "rate", "description"];
    protected $with = ["user"];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, "user_id");
    }

    public function review_images(): HasMany {
        return $this->hasMany(ReviewImage::class, "review_id");
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, "product_id");
    }
}
