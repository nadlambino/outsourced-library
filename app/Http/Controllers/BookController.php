<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRequest;
use App\Http\Requests\ReturnRequest;
use App\Services\LibraryService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class BookController extends Controller
{
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

    public function return(ReturnRequest $request, LibraryService $libraryService): RedirectResponse
    {
        try {
            $libraryService->returnBook($request->validated('history'));

            session()->flash('message', 'Successfully returned a book.');
            $response = redirect('shelve');
        } catch (Exception) {
            $errors = new MessageBag();
            $errors->add('history_id', "Something went wrong while returning the book.");

            $response = redirect('shelve')->withErrors($errors);
        }

        return $response;
    }
}
