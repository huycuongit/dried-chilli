<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Base64ImageStore;
use App\Support\UploadLimits;
use Illuminate\Http\Request;

class PageImageController extends Controller
{
    public function store(Request $request)
    {
        abort_unless(userHasAnyPermission(['admin.systems.pages']), 403);
        $limit = UploadLimits::imageBytes();
        $request->validate(['image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:' . (int) floor($limit / 1024)]]);
        $file = $request->file('image');
        $data = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        return response()->json(['url' => Base64ImageStore::store($data, 'page-images')], 201);
    }
}
