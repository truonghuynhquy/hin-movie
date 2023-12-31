<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class GenreController extends Controller
{
    public function index()
    {
        $perPage = Request::input('perPage') ?: 5;

        return Inertia::render('Genres/Index', [
            'genres' => Genre::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->paginate($perPage)
                ->appends([
                    'search' => Request::input('search'),
                    'perPage' => Request::input('perPage')
                ]),
            'filters' => Request::only(['search', 'perPage'])
        ]);
    }

    public function store()
    {
        $tmdb_genres = Http::asJson()->get(config('services.tmdb.endpoint') . 'genre/movie/list?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if ($tmdb_genres->successful()) {
            $tmdb_genres_json = $tmdb_genres->json();
            foreach ($tmdb_genres_json as $single_tmdb_genre) {
                foreach ($single_tmdb_genre as $tgenre) {
                    $genre = Genre::where('tmdb_id', $tgenre['id'])->first();
                    if (!$genre) {
                        Genre::create([
                            'tmdb_id' => $tgenre['id'],
                            'title' => $tgenre['name'],
                        ]);
                    }
                }
            }
            return Redirect::back()->with('flash.banner', 'Genre Created Successfully.');
        } else {
            return Redirect::back()->with('flash.banner', 'Api error.')->with('flash.bannerStyle', 'danger');
        }
    }

    public function edit(Genre $genre)
    {
        return Inertia::render('Genres/Edit', ['genre' => $genre]);
    }

    function update(Genre $genre)
    {
        $validated = Request::validate([
            'title' => 'required'
        ]);
        $genre->update($validated);
        return Redirect::route('admin.genres.index')->with('flash.banner', 'Genre Updated Successful.');
    }

    function destroy(Genre $genre)
    {
        try {
            $genre->delete();
            return Redirect::route('admin.genres.index')->with('flash.banner', 'Genre Deleted Successfully.')->with('flash.bannerStyle', 'danger');
        } catch (\Throwable $e) {
            return Redirect::route('admin.genres.index')->with('flash.banner', 'Genre Deleted Failed. Because this genre is already linked')->with('flash.bannerStyle', 'danger');
        }
    }
}
