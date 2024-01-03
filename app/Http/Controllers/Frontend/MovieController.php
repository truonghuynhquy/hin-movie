<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class MovieController extends Controller
{

    public function expenseMoney($amount)
    {
        if ($amount === 0) {
            return 'Unknown';
        } else {
            return '$' . number_format($amount, 0, ',', '.');
        }
    }
    public function index()
    {
        $movies = Movie::orderBy('created_at', 'desc')->with('genres')->paginate(12);

        foreach ($movies as $movie) {
            $movie->percentMovie = $movie->rating * 10;
        }

        return Inertia::render('Frontend/Movies/Index', [
            'movies' => $movies,
        ]);
    }

    public function show(Movie $movie)
    {
        $tmdb_movie = Http::asJson()->get(config('services.tmdb.endpoint') . 'movie/' . $movie['tmdb_id'] . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');

        if ($tmdb_movie->successful()) {
            $movie->budget = $this->expenseMoney($tmdb_movie['budget']);
            $movie->revenue = $this->expenseMoney($tmdb_movie['revenue']);
            $movie->status = $tmdb_movie['status'];
        }


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
            'downloads' => $movie->downloads,
        ]);
    }
}
