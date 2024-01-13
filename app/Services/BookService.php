<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookService
{
    /**
     * The default number of books per page if per_page is not provided in request.
     */
    protected const PER_PAGE = 5;

    /**
     * Service constructor.
     *
     * @param Book $book The book model.
     */
    public function __construct(protected Book $book)
    {
    }

    /**
     * Get a paginated collection of books.
     *
     * @param array $filters The query filters.
     * @return LengthAwarePaginator The paginated collection.
     */
    public function paginated(array $filters = []): LengthAwarePaginator
    {
        $perPage = $filters['per_page'] ?? self::PER_PAGE;
        $title = $filters['title'] ?? null;
        $author = $filters['author'] ?? null;
        $library = $filters['library'] ?? null;

        return $this->book->query()
            ->with(['author', 'library'])
            ->when($title, function ($query) use ($title) {
                $query->where('title', 'LIKE', "%$title%");
            })
            ->when($author, function ($query) use ($author) {
                $query->whereHas('author', function ($query) use ($author) {
                    $query->where('name', 'LIKE', "%$author%");
                });
            })
            ->when($library, function ($query) use ($library) {
                $query->whereHas('library', function ($query) use ($library) {
                    $query->where('name', 'LIKE', "%$library%");
                });
            })
            ->paginate($perPage);
    }
}
