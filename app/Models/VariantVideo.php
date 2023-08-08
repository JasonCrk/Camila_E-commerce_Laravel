<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantVideo extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'variant_videos';
    protected $keyType = 'string';

    public $incrementing = false;

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
}
