<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantColorImage extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'variant_color_image';
    protected $keyType = 'string';

    public $incrementing = false;

    public function color(): BelongsTo
    {
        return $this->belongsTo(VariantColor::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(VariantImage::class);
    }
}
