<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Wedding;

class PhotoController extends Controller
{
    public function store(Request $request, $wedding_code)
    {
        $validated = $request->validate([
            'image_url' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $wedding = Wedding::where('wedding_code', $wedding_code)->first();

        if (!$wedding) {
            return response()->json(['message' => 'Wedding not found'], 404);
        }

        $photo = Photo::create([
            'wedding_id' => $wedding->id,        // ← from URL
            'visitor_id' => $request->user()->id, // ← logged in visitor
            'image_url'  => $validated['image_url'],
        ]);

        return response()->json([
            'message' => 'Photo uploaded successfully',
            'data'    => $photo,
        ], 201);
    }

    public function index(Request $request, $wedding_code)
    {
        $wedding = Wedding::where('wedding_code', $wedding_code)->first();

        if (!$wedding) {
            return response()->json(['message' => 'Wedding not found'], 404);
        }

        $photos = Photo::where('wedding_id', $wedding->id)->get();

        return response()->json([
            'data' => $photos
        ]);
    }
}