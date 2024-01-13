<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRequest;
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
}
