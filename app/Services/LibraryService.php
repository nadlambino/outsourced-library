<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BorrowHistory;
use App\Models\Library;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LibraryService
{
    public function __construct(protected Library $library, protected BorrowHistory $borrowHistory) { }

    public function all(): Collection
    {
        return $this->library->all();
    }

    public function getBooksByLibrary(Library $library): Collection
    {
        return $library->books()->get();
    }

    /**
     * @throws Exception
     */
    public function borrowBook(Authenticatable $user, int $bookId): Book
    {
        try {
            DB::beginTransaction();

            $book = $this->findBookToBorrow($user, $bookId);
            $this->setBookAsBorrowed($book);
            $this->createBorrowHistory($user, $book);

            DB::commit();

            return $book;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @param Authenticatable $user
     * @param int $bookId
     * @return Book
     * @throws Exception
     */
    protected function findBookToBorrow(Authenticatable $user, int $bookId): Book
    {
        /** @var Book $book */
        $book = $user->library->books->find($bookId);

        if (empty($book)) {
            throw new Exception("Your library doesn't have this book!");
        }

        if ($book->is_borrowed) {
            throw new Exception("Book has already been borrowed!");
        }

        return $book;
    }

    protected function setBookAsBorrowed(Book $book, bool $isBorrowed = true): void
    {
        $book->update(['is_borrowed' => $isBorrowed]);
    }

    protected function createBorrowHistory(Authenticatable $user, Book $book): void
    {
        $this->borrowHistory->query()->create([
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);
    }
}
