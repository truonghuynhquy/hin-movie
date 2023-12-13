<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TvShowController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/TvShows/Index', [
            'tvShows' => TvShow::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    public function show()
    {
    }

    public function seasonShow()
    {
    }
}
