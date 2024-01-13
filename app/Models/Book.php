<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['is_borrowed'];

    protected $appends = ['status'];

    public function status(): Attribute
    {
        return Attribute::get(fn() => $this->is_borrowed ? 'Borrowed' : 'Available');
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
