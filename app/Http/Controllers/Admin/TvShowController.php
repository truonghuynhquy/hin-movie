<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TvShowController extends Controller
{
    public function index()
    {
        $perPage = Request::input('perPage') ?: 5;

        return Inertia::render('TvShows/Index', [
            'tvShows' => TvShow::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
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
        $tvShow = TvShow::where('tmdb_id', Request::input('tvShowTMDBId'))->first();
        if ($tvShow) {
            return Redirect::back()->with('flash.banner', 'Tv Show Exists.');
        }
        $tmdb_tv = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' . Request::input('tvShowTMDBId') . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if ($tmdb_tv->successful()) {
            try {
                TvShow::create([
                    'tmdb_id' => $tmdb_tv['id'],
                    'name'    => $tmdb_tv['name'],
                    'poster_path' => $tmdb_tv['poster_path'],
                    'created_year' => $tmdb_tv['first_air_date']
                ]);
            } catch (Exception $e) {
                return Redirect::back()->with('flash.banner', 'There is an error. Cannot create. Please enter again.')->with('flash.bannerStyle', 'danger');
            }
            return Redirect::back()->with('flash.banner', 'Tv Show Created Successfully.');
        } else {
            return Redirect::back()->with('flash.banner', 'Api error.')->with('flash.bannerStyle', 'danger');
        }
    }

    public function edit(TvShow $tvShow)
    {
        return Inertia::render('TvShows/Edit', ['tvShow' => $tvShow]);
    }

    public function update(TvShow $tvShow)
    {
        $validated = Request::validate([
            'name'    => 'required',
            'poster_path' => 'required'
        ]);
        $tvShow->update($validated);
        return Redirect::route('admin.tv-shows.index')->with('flash.banner', 'Tv Show updated.');
    }

    public function destroy(TvShow $tvShow)
    {
        try {
            $tvShow->delete();
            return Redirect::route('admin.tv-shows.index')->with('flash.banner', 'Tv Show Deleted Successfully.')->with('flash.bannerStyle', 'danger');
        } catch (\Throwable $e) {
            return Redirect::back()->with('flash.banner', 'Tv Show Deleted Failed. Because this tv show is already linked')->with('flash.bannerStyle', 'danger');
        }
    }
}
