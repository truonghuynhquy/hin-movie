<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TagController extends Controller
{
    function index()
    {
        $perPage = Request::input('perPage') ?: 5;
        return Inertia::render('Tags/Index', [
            'tags' => Tag::query()
                ->when(Request::input('search'), fn ($query, $search) => $query->where('tag_name', 'LIKE', '%' . $search . '%'))
                ->paginate($perPage)
                ->appends([
                    'search' => Request::input('search'),
                    'perPage' => Request::input('perPage')
                ]),

            'filters' => Request::only(['search', 'perPage'])
        ]);
    }

    function create()
    {
        return Inertia::render('Tags/Create');
    }

    function store()
    {
        Tag::create([
            'tag_name' => Request::input('tagName'),
            'slug' => Str::slug(Request::input('tagName'))
        ]);

        return Redirect::route('admin.tags.index')->with('flash.banner', 'Tag created successfully.');
    }

    function edit(Tag $tag)
    {
        return Inertia::render('Tags/Edit', [
            'tag' => $tag
        ]);
    }

    function update(Tag $tag)
    {
        $tag->update([
            'tag_name' => Request::input('tagName'),
            'slug' => Str::slug(Request::input('tagName'))
        ]);
        return Redirect::route('admin.tags.index')->with('flash.banner', 'Tag updated successfully.');
    }

    function destroy(Tag $tag)
    {
        $tag->delete();
        return Redirect::route('admin.tags.index')->with('flash.banner', 'Tag deleted successfully.')->with('flash.bannerStyle', 'danger');
    }
}
