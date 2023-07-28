<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipping extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'shippings';

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
