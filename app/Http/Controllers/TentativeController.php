<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Tentative;
use App\Models\Wedding;

class TentativeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $wedding = Wedding::where('wedder_id', $user->id)->first();
        if (!$wedding) {
            return response()->json(['error' => 'Wedding not found'], 404);
        }

        $tentatives = Tentative::where('wedding_id', $wedding->id)->get();
        if ($tentatives->isEmpty()) {
            return response()->json(['message' => 'No tentatives found'], 200);
        }

        return response()->json([
            'data' => $tentatives
        ]);
    }
    
    public function store(Request $request){
        $user = $request->user();
        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $time = $request->input('time');
        $title = $request->input('title');
        $note = $request->input('note');

        $wedding = Wedding::where('wedder_id', $user->id)->first();
        if(!$wedding){
            return response()->json(['error' => 'Wedding not found'], 404);
        };

        $data = Tentative::where('wedding_id', $wedding->id)->get();

        $tentative = Tentative::create([
            'wedding_id' => $wedding->id,
            'time' => $time,
            'title' => $title,
            'note' => $note,
        ]);
        
        $alltentatives = Tentative::where('wedding_id', $wedding->id)->get();
        

        return response()->json([
            'message' => 'Tentative created successfully',
            'data' => $tentative,
            'all_tentatives' => $alltentatives
        ]);
    }

    public function destroy(Request $request){
        
        $user = $request->user();
            if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $tentativeId = $request->input('tentative_id');
        
        $tentative = Tentative::where('id', $tentativeId)->first();
        if (!$tentative) {
            return response()->json(['error' => 'Tentative not found'], 404);
        }

        $tentative->delete();

        return response()->json([
            'message' => 'Tentative deleted successfully',
        ]);
    }

    public function publish(Request $request){
        $user = $request->user();
        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $wedding = Wedding::where('wedder_id', $user->id)->first();
        if(!$wedding){
            return response()->json(['error' => 'Wedding not found'], 404);
        }
        $tentatives = Tentative::where('wedding_id', $wedding->id)->update(['is_published' => true]);

        return response()->json([
            'message' => 'Tentatives published successfully',
            'data' => $tentatives
        ]);
    }
}