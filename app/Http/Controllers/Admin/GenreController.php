<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GenreController extends Controller
{
    function index()
    {
        return Inertia::render('Genres/Index');
    }
}
