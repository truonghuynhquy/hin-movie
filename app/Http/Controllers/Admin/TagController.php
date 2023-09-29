<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TagController extends Controller
{
    function index()
    {
        return Inertia::render('Tags/Index');
    }

    function create()
    {
        return Inertia::render('Tags/Create');
    }
}
