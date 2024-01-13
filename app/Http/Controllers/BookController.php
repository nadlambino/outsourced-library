<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRequest;
use App\Http\Requests\ReturnRequest;
use App\Http\Resources\BooksResource;
use App\Services\BookService;
use App\Services\LibraryService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class BookController extends Controller
{
    /**
     * Get all the books.
     *
     * @param BookService $bookService The book service.
     * @param Request $request The request object.
     * @return BooksResource The book collection resource.
     */
    public function index(BookService $bookService, Request $request): BooksResource
    {
        return new BooksResource($bookService->paginated($request->all()));
    }

    /**
     * Let the authenticated user to borrow a book.
     *
     * @param BorrowRequest $request The borrow request object.
     * @param LibraryService $libraryService The library service.
     * @return RedirectResponse The response to redirect the user back to the library page.
     */
    public function borrow(BorrowRequest $request, LibraryService $libraryService): RedirectResponse
    {
        try {
            $libraryService->borrowBook(Auth::user(), $request->validated('book'));

            session()->flash('message', 'Successfully borrowed a book.');
            $response = redirect('library');
        } catch (Exception $exception) {
            $errors = new MessageBag();
            $errors->add('book', $exception->getMessage());

            $response = redirect('library')->withErrors($errors);
        }

        return $response;
    }

    /**
     * Let the user return a borrowed book.
     *
     * @param ReturnRequest $request The return request object.
     * @param LibraryService $libraryService The library service.
     * @return RedirectResponse The response to redirect the user back to shelf page.
     */
    public function return(ReturnRequest $request, LibraryService $libraryService): RedirectResponse
    {
        try {
            $libraryService->returnBook($request->validated('history'));

            session()->flash('message', 'Successfully returned a book.');
            $response = redirect('shelf');
        } catch (Exception) {
            $errors = new MessageBag();
            $errors->add('history', "Something went wrong while returning the book.");

            $response = redirect('shelf')->withErrors($errors);
        }

        return $response;
    }
}
