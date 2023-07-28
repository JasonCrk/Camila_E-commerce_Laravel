<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cities';

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
