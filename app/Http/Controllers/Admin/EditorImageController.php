<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorImageController extends Controller
{
    public function store(Request $request)
    {
        abort_unless(userHasAnyPermission([
            'admin.projects.create', 'admin.projects.edit',
            'admin.services.create', 'admin.services.edit',
            'admin.news.create', 'admin.news.edit',
        ]), 403);

        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $path = $request->file('image')->store('editor-images', 'public');

        return response()->json(['url' => Storage::disk('public')->url($path)], 201);
    }
}
