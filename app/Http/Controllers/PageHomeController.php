<?php

namespace App\Http\Controllers;

use App\Models\Course;

class PageHomeController extends Controller
{
    public function __invoke()
    {
        $courses = Course::released()
            ->orderByDesc('released_at')
//            ->where('released_at', null)
            ->get();

        return view('pages.home', ['courses'=>$courses]);
    }
}

