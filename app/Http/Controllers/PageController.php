<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\LibraryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function shelve(): View
    {
        return view('pages.shelve');
    }

    public function library(LibraryService $libraryService): View
    {
        $books = $libraryService->getBooksByLibrary(Auth::user()?->library);

        return view('pages.library', compact('books'));
    }
}
