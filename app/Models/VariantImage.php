<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VariantImage extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'variant_images';

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function colors(): HasMany
    {
        return $this->hasMany(VariantColorImage::class);
    }
}
