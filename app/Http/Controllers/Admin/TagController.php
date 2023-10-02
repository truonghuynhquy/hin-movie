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
        return Inertia::render('Tags/Index', [
            'tags' => Tag::paginate(5)
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
}
