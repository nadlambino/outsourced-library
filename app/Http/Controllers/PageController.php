<?php

namespace App\Http\Controllers;

use App\Services\LibraryService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Render shelve page.
     *
     * @param LibraryService $libraryService
     * @return View
     */
    public function shelve(LibraryService $libraryService): View
    {
        $histories = $libraryService->getBorrowHistoryByUser(Auth::user(), ['is_returned' => false]);

        return view('pages.shelve', compact('histories'));
    }

    /**
     * Render library page.
     *
     * @param LibraryService $libraryService
     * @return View
     */
    public function library(LibraryService $libraryService): View
    {
        $books = $libraryService->getBooksByLibrary(Auth::user()?->library);

        return view('pages.library', compact('books'));
    }

    /**
     * Render history page.
     *
     * @param LibraryService $libraryService
     * @return View
     */
    public function history(LibraryService $libraryService): View
    {
        $histories = $libraryService->getBorrowHistoryByUser(Auth::user());

        return view('pages.history', compact('histories'));
    }
}
