<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function showForm()
    {
        return view('admin.link-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        Link::create(['url' => $request->url]);

        return redirect()->back()->with('success', /*'Link guardado correctamente.'*/);
    }

    public function showLink()
    {
        $link = Link::latest()->first();
        return view('user.view-link', compact('link'));
    }
}
