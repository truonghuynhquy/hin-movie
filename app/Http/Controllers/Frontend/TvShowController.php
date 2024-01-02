<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class TvShowController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/TvShows/Index', [
            'tvShows' => TvShow::orderBy('created_at', 'desc')->paginate(12)
        ]);
    }

    public function show(TvShow $tvShow)
    {
        $tmdb_tv = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' . $tvShow['tmdb_id'] .  '?api_key=' . config('services.tmdb.secret') . '&language=en-US');

        if ($tmdb_tv->successful()) {
            if ($tmdb_tv['overview'] == null || $tmdb_tv['overview'] == '') {
                $tvShow->overView = "We don't have an overview translated in English. Help us expand our database by adding one.";
            } else {
                $tvShow->overView = $tmdb_tv['overview'];
            }
            // Genres list
            $genres = $tmdb_tv['genres'];
            $tvShow->genreNames = array_column($genres, 'name');
            // Creator
            $creators = $tmdb_tv['created_by'];
            if ($creators != null) {
                $tvShow->creatorNames = $creators[0]['name'];
            }
        }

        $latests = Movie::orderBy('created_at', 'desc')->take(9)->get();

        return Inertia::render('Frontend/TvShows/Show', [
            'tvShow' => $tvShow,
            'seasons' => $tvShow->seasons,
            'latests' => $latests
        ]);
    }

    public function seasonShow(TvShow $tvShow, Season $season)
    {
        $tmdb_season = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' . $tvShow['tmdb_id'] . '/season/' . (int)$season['season_number'] . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');

        if ($tmdb_season->successful()) {
            if ($tmdb_season['overview'] == null || $tmdb_season['overview'] == '') {
                $season->overView = "We don't have an overview translated in English. Help us expand our database by adding one.";
            } else {
                $season->overView = $tmdb_season['overview'];
            }
        }

        $latests = Movie::orderBy('created_at', 'desc')->take(9)->get();

        return Inertia::render('Frontend/TvShows/Seasons/Show', [
            'latests' => $latests,
            'tvShow' => $tvShow,
            'episodes' => $season->episodes,
            'season' => $season
        ]);
    }

    public function showEpisode(Episode $episode)
    {

        $latests = Episode::latest()->take(10)->get();
        return Inertia::render('Frontend/Episodes/Show', [
            'episode' => $episode,
            'season' => $episode->season,
            'latests' => $latests
        ]);
    }
}
