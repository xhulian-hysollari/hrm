<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Post;

class HomeController extends Controller
{
    /**
     * Show the profile config page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('welcome-employee', compact('posts'));
    }
}
