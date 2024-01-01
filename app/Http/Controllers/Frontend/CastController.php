<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class CastController extends Controller
{
    public function genderCast($gender)
    {
        if ($gender === 1) {
            return 'Female';
        } elseif ($gender === 2) {
            return 'Male';
        }
    }
    public function index()
    {
        return Inertia::render('Frontend/Casts/Index', [
            'casts' => Cast::orderBy('updated_at', 'desc')->paginate(10)
        ]);
    }

    public function show(Cast $cast)
    {
        $tmdb_cast = Http::asJson()->get(config('services.tmdb.endpoint') . 'person/' . $cast['tmdb_id'] . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');

        if ($tmdb_cast->successful()) {
            if ($tmdb_cast['biography'] == null || $tmdb_cast['biography'] == '') {
                $cast->biography = "We don't have an overview translated in English. Help us expand our database by adding one.";
            } else {
                $cast->biography = $tmdb_cast['biography'];
                $cast->birthday = $tmdb_cast['birthday'];
                $cast->placeOfBirth = $tmdb_cast['place_of_birth'];
                $cast->gender = $this->genderCast($tmdb_cast['gender']);
            }
        }

        $movies = $cast->movies;

        return Inertia::render('Frontend/Casts/Show', [
            'cast' => $cast,
            'movies' => $movies
        ]);
    }
}
