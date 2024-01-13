<?php

namespace App\Services;

use App\Models\Library;
use Illuminate\Database\Eloquent\Collection;

class LibraryService
{
    public function __construct(protected Library $library) { }

    public function all(): Collection
    {
        return $this->library->all();
    }

    public function getBooksByLibrary(Library $library): Collection
    {
        return $library->books()->get();
    }
}
