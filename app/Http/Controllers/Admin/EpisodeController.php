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
}
