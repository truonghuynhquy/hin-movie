<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index()
    {
        $perPage = Request::input('perPage') ?: 5;
        return Inertia::render('Movies/Index', [
            'movies' => Movie::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('title', 'LIKE', "%{$search}%");
                })
                ->paginate($perPage)
                ->appends([
                    'search' => Request::input('search'),
                    'perPage' => Request::input('perPage')
                ]),
            'filters' => Request::only(['search', 'perPage']),
        ]);
    }

    public function store()
    {
        $movie = Movie::where('tmdb_id', Request::input('movieTMDBId'))->exists();
        if ($movie) {
            return Redirect::back()->with('flash.banner', 'Movie Exists.');
        }
        $apiMovie = Http::asJson()->get(config('services.tmdb.endpoint') . 'movie/' . Request::input('movieTMDBId') . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');

        if ($apiMovie->successful()) {
            try {
                $create_movie = Movie::create([
                    'tmdb_id' => $apiMovie->json()['id'],
                    'title' => $apiMovie->json()['title'],
                    'runtime' => $apiMovie->json()['runtime'],
                    'rating' => $apiMovie->json()['vote_average'],
                    'release_date' => $apiMovie->json()['release_date'],
                    'lang' => $apiMovie->json()['original_language'],
                    'video_format' => 'HD',
                    'is_public' => false,
                    'overview' => $apiMovie->json()['overview'],
                    'poster_path' => $apiMovie->json()['poster_path'],
                    'backdrop_path' => $apiMovie->json()['backdrop_path'],
                ]);
                $tmdb_genres = $apiMovie['genres'];
                $tmdb_genres_ids = collect($tmdb_genres)->pluck('id');
                $genres = Genre::whereIn('tmdb_id', $tmdb_genres_ids)->get();
                $create_movie->genres()->attach($genres);
            } catch (\Throwable $e) {
                return Redirect::back()->with('flash.banner', 'There is an error. Cannot create. Please enter again.')->with('flash.bannerStyle', 'danger');
            }
            return Redirect::back()->with('flash.banner', 'Movie create.');
        } else {
            return Redirect::back()->with('flash.banner', 'Api error.');
        }
    }

    public function edit(Movie $movie)
    {
        return Inertia::render('Movies/Edit', ['movie' => $movie]);
    }

    public function update(Movie $movie)
    {
        $movie->update(Request::validate([
            'title' => 'required',
            'poster_path' => 'required',
            'runtime' => 'required',
            'lang' => 'required',
            'video_format' => 'required',
            'rating' => 'required',
            'backdrop_path' => 'required',
            'overview' => 'required',
            'is_public' => 'required'
        ]));
        return Redirect::route('admin.movies.index')->with('flash.banner', 'Movie Updated Successful.');
    }

    public function destroy(Movie $movie)
    {
        $movie->genres()->sync([]);
        $movie->delete();
        return Redirect::route('admin.movies.index')->with('flash.banner', 'Movie Deleted Successfully.')->with('flash.bannerStyle', 'danger');
    }
}
