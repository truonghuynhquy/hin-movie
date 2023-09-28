<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TvShowController extends Controller
{
    function index()
    {
        return Inertia::render('TvShows/Index');
    }
}
