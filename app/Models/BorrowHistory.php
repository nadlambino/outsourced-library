<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method findOrFail(int $historyId)
 */
class BorrowHistory extends Model
{
    use HasFactory;

    /**
     * @var string[] The fillable columns.
     */
    protected $fillable = ['user_id', 'book_id', 'borrowed_at', 'returned_at'];

    /**
     * @var bool Turn off the timestamps, created_at and updated_at.
     */
    public $timestamps = false;

    /**
     * The relationship method to get whom this history belongs to.
     *
     * @return BelongsTo
     */
    public function borrower(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The relationship method to get the book recorded from this history.
     *
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
