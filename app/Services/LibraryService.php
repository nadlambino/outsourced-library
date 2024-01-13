<?php

namespace App\Services;

use App\Exceptions\BookNotAvailableException;
use App\Exceptions\BookNotFoundException;
use App\Models\Book;
use App\Models\BorrowHistory;
use App\Models\Library;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LibraryService
{
    public function __construct(
        protected Library       $library,
        protected Book          $book,
        protected BorrowHistory $borrowHistory
    )
    {
    }

    public function all(): Collection
    {
        return $this->library->all();
    }

    public function getBorrowHistoryByUser(Authenticatable $user, bool $isReturned = false): Collection
    {
        return $user->borrowHistory()
            ->when($isReturned, function ($query) {
                $query->whereNotNull('returned_at');
            })
            ->when(!$isReturned, function ($query) {
                $query->whereNull('returned_at');
            })
            ->with('book')
            ->get();
    }

    public function getBooksByLibrary(Library $library): Collection
    {
        return $library->books()->get();
    }

    /**
     * Let the user borrow a book from the library where they're associated with.
     *
     * @param Authenticatable $user The authenticated user.
     * @param int $bookId The book ID to borrow.
     * @return Book The borrowed book instance.
     * @throws BookNotFoundException Throw if book is not found on the associated library.
     * @throws BookNotAvailableException Throw if the book has already been borrowed.
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
     * @param int $historyId
     * @return mixed
     * @throws Exception
     */
    public function returnBook(int $historyId)
    {
        try {
            DB::beginTransaction();

            $history = $this->borrowHistory->findOrFail($historyId);

            $this->setBookAsBorrowed($history->book, false);
            $history->update(['returned_at' => now()]);

            DB::commit();

            return $history->fresh();
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Find the book from the authenticated user's associated library.
     *
     * @param Authenticatable $user The authenticated user.
     * @param int $bookId The book ID to borrow.
     * @return Book The borrowed book instance.
     * @throws BookNotFoundException Throw if book is not found on the associated library.
     * @throws BookNotAvailableException Throw if the book has already been borrowed.
     */
    protected function findBookToBorrow(Authenticatable $user, int $bookId): Book
    {
        /** @var Book $book */
        $book = $user->library->books->find($bookId);

        if (empty($book)) {
            throw new BookNotFoundException("Your library doesn't have this book!");
        }

        if ($book->is_borrowed) {
            throw new BookNotAvailableException("Book has already been borrowed!");
        }

        return $book;
    }

    /**
     * Set the book status whether it is borrowed or not.
     *
     * @param Book $book The book instance.
     * @param bool $isBorrowed Determine whether it is borrowed or not.
     * @return bool Whether the update was successful.
     */
    protected function setBookAsBorrowed(Book $book, bool $isBorrowed = true): bool
    {
        return $book->update(['is_borrowed' => $isBorrowed]);
    }

    /**
     * Create a new borrow history.
     *
     * @param Authenticatable $user The authenticated user who borrowed the book.
     * @param Book $book The book instance that was borrowed.
     * @return void
     */
    protected function createBorrowHistory(Authenticatable $user, Book $book): void
    {
        $this->borrowHistory->query()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'returned_at' => null
        ]);
    }
}
