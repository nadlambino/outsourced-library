<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\LibraryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function shelve(LibraryService $libraryService): View
    {
        $histories = $libraryService->getBorrowHistoryByUser(Auth::user());

        return view('pages.shelve', compact('histories'));
    }

    public function library(LibraryService $libraryService): View
    {
        $books = $libraryService->getBooksByLibrary(Auth::user()?->library);

        return view('pages.library', compact('books'));
    }
}
