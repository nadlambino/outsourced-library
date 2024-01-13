<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BorrowHistory extends Model
{
    use HasFactory;

    public const CREATED_AT = 'borrowed_at';

    public const UPDATED_AT = 'returned_at';

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
