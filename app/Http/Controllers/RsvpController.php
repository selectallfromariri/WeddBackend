<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rsvp;
use App\Models\Wedding;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\BankQrController;
use App\Http\Controllers\TentativeController;

class RsvpController extends Controller
{

    public function index(Request $request){
        $user = $request->user();
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $wedding = Wedding::where('id', $user->id)->first();

        $rsvp = Rsvp::where('wedding_id', $wedding->id)->get();

        if($rsvp->isEmpty()){
            return response()->json(['message' => 'No data yet'], 404);
        }

        return response()->json([
            'data' => $rsvp
        ]);

    }

    public function show(Request $request, $wedding_code)
{
    $wedding = Wedding::where('wedding_code', $wedding_code)->first();

    if (!$wedding) {
        return response()->json(['message' => 'Wedding not found'], 404);
    }

    $rsvp = Rsvp::where('wedding_id', $wedding->id)
                 ->where('visitor_id', $request->user()->id)
                 ->first();

    if (!$rsvp) {
        return response()->json(['message' => 'No RSVP found'], 404);
    }

    return response()->json(['data' => $rsvp]);
}

    public function store(Request $request, $wedding_code){
        $user = $request->user();
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 401);
        };

        $validate = $request->validate([
            'attendance' => 'required|in:attending,not_attending',
            'note' => 'nullable|string|max:255',
        ]);

        $wedding = Wedding::where('wedding_code', $wedding_code)->first();

        if(!$wedding){
            return response()->json(['message' => 'Wedding not found'], 404);
        };

        $existing = Rsvp::where('wedding_id', $wedding->id)->where('visitor_id', $user->id)->first();

        if($existing){
            return response()->json(['message' => 'You have already RSVP to this wedding'], 400);
        }

        $rsvp = Rsvp::create([
            'wedding_id' => $wedding->id,
            'visitor_id' => $user->id,
            'attendance' => $validate['attendance'],
            'note' => $validate['note'] ?? null,
        ]);

        return response()->json([
            'message' => 'RSVP submitted successfully',
            'data' => $rsvp,
        ], 201);

    }
}