<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CastController extends Controller
{
    function index()
    {
        return Inertia::render('Casts/Index', [
            'casts' => Cast::paginate(5),
            'filters' => Request::only(['search', 'perPage']),
        ]);
    }
}
