<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function shelve(): View
    {
        return view('pages.shelve');
    }

    public function libraries(): View
    {
        return view('pages.libraries');
    }
}
