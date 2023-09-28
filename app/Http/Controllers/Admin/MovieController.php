<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    function index()
    {
        return Inertia::render('Movies/Index');
    }
}
