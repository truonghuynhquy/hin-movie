<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('created_at', 'desc')->with('genres')->paginate(10);

        foreach ($movies as $movie) {
            $movie->percentMovie = $movie->rating * 10;
        }

        return Inertia::render('Frontend/Movies/Index', [
            'movies' => $movies,
        ]);
    }

    public function show()
    {
    }
}
