<?php

namespace App\Http\Controllers;

use App\Services\LibraryService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Render shelf page.
     *
     * @param LibraryService $libraryService
     * @return View
     */
    public function shelf(LibraryService $libraryService): View
    {
        $histories = $libraryService->getBorrowHistoryByUser(Auth::user(), ['is_returned' => false]);

        return view('pages.shelf', compact('histories'));
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
