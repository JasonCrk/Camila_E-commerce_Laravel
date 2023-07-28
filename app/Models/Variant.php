<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variant extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'variants';

    protected $fillable = [
        'product_id',
        'list_price',
        'discount_price',
        'stock'
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(VariantProductSize::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(VariantImage::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(VariantVideo::class);
    }

    public function inWhishListItems(): HasMany
    {
        return $this->hasMany(WhishListItem::class);
    }

    public function inCartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
