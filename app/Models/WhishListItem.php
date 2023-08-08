<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhishListItem extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'whish_list_items';
    protected $keyType = 'string';

    public $incrementing = false;

    public function whishList(): BelongsTo
    {
        return $this->belongsTo(WhishList::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
}
