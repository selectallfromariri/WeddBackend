<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankQr;
use App\Models\Wedding;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeddingController;


class BankQrController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $wedding = Wedding::where('wedder_id', $user->id)->first();
        if(!$wedding){
            return response()->json(['message' => 'Wedding not found'], 404);
        };

        $bankQr = BankQr::where('wedding_id', $wedding->id)->first();
        if(!$bankQr){
            return response()->json(['message' => 'Bank QR not found'], 404);
        };

        return response()->json([
            'data' => $bankQr
        ]);
    }

    public function update(Request $request){
            $user = $request->user();
            if(!$user){
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $bank_name = $request->input('bank_name');
            $account_name = $request->input('account_name');
            $account_number = $request->input('account_number');
            $qr_image = $request->input('qr_image');

            $wedding = Wedding::where('wedder_id', $user->id)->first();
            if(!$wedding){
                return response()->json(['message' => 'Wedding not found'], 404);
            };

            $weddingId = $wedding->id;

            $updatebank = BankQr::where('wedding_id', $weddingId)->update([
                'wedding_id' => $weddingId,
                'bank_name' => $bank_name,
                'account_name' => $account_name,
                'account_number' => $account_number,
                'qr_image' => $qr_image,
            ]);

            if(!$updatebank){
                return response()->json(['message' => 'Failed to update Bank QR'], 500);
            }

            return response()->json([
                'message' => 'Bank QR updated successfully',
            ]);
    }

    public function store(Request $request){
        $user = $request->user();
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $bank_name = $request->input('bank_name');
        $account_name = $request->input('account_name');
        $account_number = $request->input('account_number');
        $qr_image = $request->input('qr_image');

        $wedding = Wedding::where('id', $user->id)->first();
        if(!$wedding){
            return response()->json(['message' => 'Wedding not found'], 404);
        };

        $bankqr = BankQr::create([
            'wedding_id' => $wedding,
            'bank_name' => $bank_name,
            'account_name' => $account_name,
            'account_number' => $account_number,
            'qr_image' => $qr_image,
        ]);


    }

    public function publish(Request $request){
        $user = $request->user();
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

            $wedding = Wedding::where('id', $user->id)->first();
            if(!$wedding){
                return response()->json(['message' => 'Wedding not found'], 404);
            };

            $bankQr = BankQr::where('wedding_id', $wedding->id)->update([
                'is_published' => true,
            ]);

            if(!$bankQr){
                return response()->json(['message' => 'Failed to publish Bank QR'], 500);
            }

            return response()->json([
                'message' => 'Bank QR published successfully',
            ]);

    }
}
        