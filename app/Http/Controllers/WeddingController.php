<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wedding;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
class WeddingController extends Controller
{
    public function store(Request $request){
        //validate this shit
        
        $validated = $request->validate([
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'date' => 'required|date',
            'venue' => 'required|string|max:255',
            'cover_photo' => 'nullable|string|max:2048',
        ]);

        //create tht shit
        $wedding = Wedding::create([
            'wedder_id' => $request->user()->id,
            'bride_name' => $validated['bride_name'],
            'groom_name' => $validated['groom_name'],
            'date' => $validated['date'],
            'venue' => $validated['venue'],
            'cover_photo' => $validated['cover_photo'] ?? null,
        ]);

        return response()->json([
            'message' => 'Wedding created successfully',
            'data' => $wedding,
        ]);
    }

    public function show(Request $request){
        $user = $request->user();
        $wedding = Wedding::where('wedder_id', $user->id)->first();
        
        if(!$wedding){
            return response()->json([
                'message' => 'No wedding yet'
            ], 404);
        }
        
        return response()->json([
            'data' => $wedding
        ]);
    }

    public function update(Request $request){
        $user = $request->user();

        $bride_name = $request->input('bride_name');
        $groom_name = $request->input('groom_name');
        $date = $request->input('date');
        $venue = $request->input('venue');
        $cover_photo = $request->input('cover_photo');

        $wedding = Wedding::where('wedder_id', $user->id)
        ->update([
            'bride_name' => $bride_name,
            'groom_name' => $groom_name,
            'date' => $date,
            'venue' => $venue,
            'cover_photo' => $cover_photo,
        ]);

        if(!$wedding){
            return response()->json([
                'message' => 'You have no wedding to update'
            ], 404);
        }

        return response()->json([
            'message' => 'Wedding updated successfully',
            'data' => $wedding,
        ]);
    }

    public function publish(Request $request){
        $user = $request->user();
        $wedding = Wedding::where('wedder_id', $user->id)
        ->update([
            'is_published' => true,
        ]);

        if(!$wedding){
            return response()->json([
                'message' => 'You have no wedding to publish'
            ], 404);
        }

        return response()->json([
            'message' => 'Wedding published successfully',
            'data' => $wedding,
        ]);
    }
    public function showByCode($wedding_code)
{
    $wedding = Wedding::where('wedding_code', $wedding_code)
                      ->where('is_published', true)
                      ->with([
                          'tentatives' => fn($q) => $q->where('is_published', true)->orderBy('time'),
                          'bankQr'     => fn($q) => $q->where('is_published', true),
                      ])
                      ->first();

    if (!$wedding) {
        return response()->json(['message' => 'Wedding not found'], 404);
    }

    return response()->json(['data' => $wedding]);
}

}