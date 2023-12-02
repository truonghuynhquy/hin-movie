<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Movie;
use App\Models\TvShow;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index(Movie $movie, TvShow $tvShow, Cast $cast, User $user)
    {
        $totalMovies = $movie->count();
        $totalTvShows = $tvShow->count();
        $totalCasts = $cast->count();
        $totalUsers = $user->count();

        return Inertia::render('Admin/Index', [
            'totalMovie' => $totalMovies,
            'totalTvShow' => $totalTvShows,
            'totalCast' => $totalCasts,
            'totalUser' => $totalUsers,
        ]);
    }
}
