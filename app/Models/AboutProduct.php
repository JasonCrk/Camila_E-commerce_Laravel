<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutProduct extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'about_products';
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'position',
        'content',
        'product_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
