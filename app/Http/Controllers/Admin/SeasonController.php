<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\TvShow;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class SeasonController extends Controller
{
    public function index(TvShow $tvShow)
    {
        $perPage = Request::input('perPage') ?: 5;

        return Inertia::render('TvShows/Seasons/Index', [
            'seasons' => Season::query()
                ->where('tv_show_id', $tvShow->id)
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->paginate($perPage)
                ->appends([
                    'search' => Request::input('search'),
                    'perPage' => Request::input('perPage')
                ]),
            'filters' => Request::only(['search', 'perPage']),
            'tvShow' => $tvShow
        ]);
    }

    public function store(TvShow $tvShow)
    {
        $season = $tvShow->seasons()->where('season_number', Request::input('seasonNumber'))->exists();
        if ($season) {
            return Redirect::back()->with('flash.banner', 'Season Exists.');
        }
        $tmdb_season = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' . $tvShow->tmdb_id . '/season/' . Request::input('seasonNumber') . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if ($tmdb_season->successful()) {
            try {
                Season::create([
                    'tv_show_id' => $tvShow->id,
                    'tmdb_id' => $tmdb_season['id'],
                    'name'    => $tmdb_season['name'],
                    'poster_path' => $tmdb_season['poster_path'],
                    'season_number' => $tmdb_season['season_number']
                ]);
            } catch (Exception $e) {
                return Redirect::back()->with('flash.banner', 'There is an error. Cannot create. Please enter again.')->with('flash.bannerStyle', 'danger');
            }

            return Redirect::back()->with('flash.banner', 'Season Created Successfully.');
        } else {
            return Redirect::back()->with('flash.banner', 'Api error.')->with('flash.bannerStyle', 'danger');
        }
    }

    public function edit(TvShow $tvShow, Season $season)
    {
        return Inertia::render('TvShows/Seasons/Edit', [
            'tvShow' => $tvShow,
            'season' => $season
        ]);
    }

    public function update(TvShow $tvShow, Season $season)
    {
        $validated = Request::validate([
            'name'    => 'required',
            'poster_path' => 'required'
        ]);
        $season->update($validated);
        return Redirect::route('admin.seasons.index', $tvShow->id)->with('flash.banner', 'Season Updated Successfully.');
    }

    public function destroy(TvShow $tvShow, Season $season)
    {
        try {
            $season->delete();
            return Redirect::route('admin.seasons.index', $tvShow->id)->with('flash.banner', 'Season Deleted Successfully.')->with('flash.bannerStyle', 'danger');
        } catch (\Throwable $e) {
            return Redirect::back()->with('flash.banner', 'Season Deleted Failed. Because this season is already linked')->with('flash.bannerStyle', 'danger');
        }
    }
}
