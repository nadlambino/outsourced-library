<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\LibraryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function shelve(): View
    {
        return view('pages.shelve');
    }

    public function libraries(LibraryService $libraryService): View
    {
        $libraries = $libraryService->all();

        return view('pages.libraries', compact('libraries'));
    }
}
