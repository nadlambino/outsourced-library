<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    /**
     * @var string[] The Fillable columns.
     */
    protected $fillable = ['is_borrowed'];

    /**
     * @var string[] The appended custom attributes.
     */
    protected $appends = ['status'];

    /**
     * Custom attribute which represent the status of the book based on is_borrowed value.
     *
     * @return Attribute
     */
    public function status(): Attribute
    {
        return Attribute::get(fn() => $this->is_borrowed ? 'Borrowed' : 'Available');
    }

    /**
     * The relationship method to get the library where this book belongs to.
     *
     * @return BelongsTo
     */
    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    /**
     * The relationship method to get the author whom this book belongs to.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
