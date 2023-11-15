<?php

namespace  App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Movie;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieAttachController extends Controller
{
    public function index(Movie $movie)
    {
        return Inertia::render(
            'Movies/Attach',
            [
                'movie' => $movie,
                'trailers' => $movie->trailers,
                'downloads' => $movie->downloads,
                'casts' => Cast::all('id', 'name'),
                'tags' => Tag::all('id', 'tag_name'),
                'movieCasts' => $movie->casts,
                'movieTags' => $movie->tags
            ]
        );
    }
}
