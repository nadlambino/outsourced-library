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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * @throws Exception
     */
    public function borrow(BorrowRequest $request, LibraryService $libraryService): RedirectResponse
    {
        try {
            $libraryService->borrowBook(Auth::user(), $request->validated('bookId'));

            session()->flash('message', 'Successfully borrowed a book.');
            $response = redirect('library');
        } catch (Exception) {
            $errors = new MessageBag();
            $errors->add('bookId', "Your library doesn't have this book!");

            $response = redirect('library')->withErrors($errors);
        }

        return $response;
    }

    public function return(ReturnRequest $request, LibraryService $libraryService): RedirectResponse
    {
        try {
            $libraryService->returnBook($request->validated('history_id'));

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
