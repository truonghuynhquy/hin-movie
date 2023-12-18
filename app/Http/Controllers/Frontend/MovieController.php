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

    public function show(Movie $movie)
    {
        $latests = Movie::orderBy('created_at', 'desc')->take(9)->get();

        $runtimeHours = floor($movie->runtime / 60);
        $runtimeMinutes = $movie->runtime % 60;
        $movie->formattedRuntime = $runtimeHours . 'h ' . $runtimeMinutes . 'm';

        return Inertia::render('Frontend/Movies/Show', [
            'movie' => $movie,
            'latests' => $latests,
            'movieGenres' => $movie->genres,
            'casts' => $movie->casts,
            'tags' => $movie->tags,
            'trailers' => $movie->trailers,
        ]);
    }
}
