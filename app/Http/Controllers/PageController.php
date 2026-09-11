<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __invoke(Request $request): View
    {
        $page = $request->route('page', 'home');

        return view('pages.'.$page, [
            'page' => $page,
            'locale' => app()->getLocale(),
        ]);
    }
}
