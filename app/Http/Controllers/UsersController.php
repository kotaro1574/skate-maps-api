<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function get(Request $request)
    {
        if ($request->has('email')) {
            $items = DB::table('users')->where('email', $request->email)->get();
            return response()->json([
                'message' => 'User get successfully',
                'data' => $items
            ], 200);
        } else {
            return response()->json(['status' => 'not found'], 404);
        }
    }
    public function show(Request $request, User $user)
    {
        $user = DB::table('users')->where('id', $user->id)->first();
        return response()->json([
            'message' => 'User get successfully',
            'data' => $user
        ], 200);
    }
    public function put(Request $request)
    {
        $request->validate([
            'name' => 'max:255',
            'profile' => 'max:600'
        ]);
        $param = [
            'name' => $request->name,
            'profile' => $request->profile,
            'userLat' => $request->userLat,
            'userLng' => $request->userLng,
            'image' => $request->file
        ];
        DB::table('users')->where('email', $request->email)->update($param);
        return response()->json([
            'message' => 'User updated successfully',
            'data' => $param
        ], 200);
    }
}
