<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VariantColor extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'variant_colors';
    protected $keyType = 'string';

    public $incrementing = false;

    public function images(): HasMany
    {
        return $this->hasMany(VariantColorImage::class);
    }
}
