<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CastController extends Controller
{
    function index()
    {
        $perPage = Request::input('perPage') ?: 5;

        return Inertia::render('Casts/Index', [
            'casts' => Cast::query()
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

    function edit(Cast $cast)
    {
        return Inertia::render('Casts/Edit', [
            'cast' => $cast
        ]);
    }

    function store()
    {
        $cast = Cast::where('tmdb_id', Request::input('castTMDBId'))->first();
        if ($cast) {
            return Redirect::back()->with('flash.banner', 'Cast already exists.')->with('flash.bannerStyle', 'danger');
        }

        $tmdb_cast = Http::asJson()->get(config('services.tmdb.endpoint') . 'person/' . Request::input('castTMDBId') . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');

        if ($tmdb_cast->successful()) {
            Cast::create([
                'tmdb_id' => $tmdb_cast['id'],
                'name'    => $tmdb_cast['name'],
                'slug'    => Str::slug($tmdb_cast['name']),
                'poster_path' => $tmdb_cast['profile_path']
            ]);
            return Redirect::back()->with('flash.banner', 'Cast Created Successfully.');
        } else {
            return Redirect::back()->with('flash.banner', 'Api error.')->with('flash.bannerStyle', 'danger');
        }
    }

    function update(Cast $cast)
    {
        $validated = Request::validate([
            'name' => 'required',
            'poster_path' => 'required'
        ]);
        $cast->update($validated);
        return Redirect::route('admin.casts.index')->with('flash.banner', 'Cast Updated Successfully.');
    }

    function destroy(Cast $cast)
    {
        try {
            $cast->delete();
            return Redirect::back()->with('flash.banner', 'Cast Deleted Successfully.')->with('flash.bannerStyle', 'danger');
        } catch (\Throwable $e) {
            return Redirect::back()->with('flash.banner', 'Cast Deleted Failed. Because this cast is already linked')->with('flash.bannerStyle', 'danger');
        }
    }
}
