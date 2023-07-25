<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static insert(mixed[] $toArray)
 */
class Invoice extends Model
{
    use HasFactory;

    public function invoices(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
