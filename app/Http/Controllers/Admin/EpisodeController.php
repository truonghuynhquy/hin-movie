<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class EpisodeController extends Controller
{
    public function index(TvShow $tvShow, Season $season)
    {
        $perPage = Request::input('perPage') ?: 5;
        return Inertia::render('TvShows/Seasons/Episodes/Index', [
            'tvShow' => $tvShow,
            'season' => $season,
            'episodes' => Episode::query()
                ->where('season_id', $season->id)
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

    public function store(TvShow $tvShow, Season $season)
    {
        $episode = $season->episodes()->where('episode_number', Request::input('episode_number'))->exists();
        if ($episode) {
            return Redirect::back()->with('flash.banner', 'Episode already exists');
        }
        $tmdb_episode = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' . $tvShow->tmdb_id . '/season/' . $season->season_number . '/episode/' . Request::input('episodeNumber') . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');

        if ($tmdb_episode->successful()) {
            try {
                Episode::create([
                    'season_id' => $season->id,
                    'tmdb_id' => $tmdb_episode->json()['id'],
                    'name' => $tmdb_episode->json()['name'],
                    'episode_number' => $tmdb_episode->json()['episode_number'],
                    'overview' => $tmdb_episode->json()['overview'],
                ]);
            } catch (\Throwable $e) {
                return Redirect::back()->with('flash.banner', 'There is an error. Cannot create. Please enter again.')->with('flash.bannerStyle', 'danger');
            }
            return Redirect::back()->with('flash.banner', 'Episode created.');
        } else {
            return Redirect::back()->with('flash.banner', 'Api error.');
        }
    }

    public function edit(TvShow $tvShow, Season $season, Episode $episode)
    {
        return Inertia::render('TvShows/Seasons/Episodes/Edit', [
            'tvShow' => $tvShow,
            'season' => $season,
            'episode' => $episode,
        ]);
    }

    public function update(TvShow $tvShow, Season $season, Episode $episode)
    {
        $validated = Request::validate([
            'name' => 'required',
            'overview' => 'required',
            'is_public' => 'required'
        ]);
        $episode->update($validated);
        return Redirect::route('admin.episodes.index', [$tvShow->id, $season->id])->with('flash.banner', 'Genre Updated Successful.');
    }

    public function destroy(TvShow $tvShow, Season $season, Episode $episode)
    {
        try {
            $episode->delete();
            return Redirect::route('admin.episodes.index', [$tvShow->id, $season->id])->with('flash.banner', 'Episode Deleted Successfully.')->with('flash.bannerStyle', 'danger');
        } catch (\Throwable $e) {
            return Redirect::back()->with('flash.banner', 'Episode Deleted Failed. Because this episode is already linked')->with('flash.bannerStyle', 'danger');
        }
    }
}
