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
    function index()
    {
        $perPage = Request::input('per_page') ?: 5;
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
}
