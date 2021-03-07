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
        if(is_string($request->file) || !$request->file){
            $param = [
                'name' => $request->name,
                'profile' => $request->profile,
                'userLat' => $request->userLat,
                'userLng' => $request->userLng,
                'image' => $request->file,
                'instagramURL' => $request->instagramURL,
                'twitterURL' => $request->twitterURL
            ];
        } else {
            $file_name = time() . '.' . $request->file->getClientOriginalName();
            $request->file->storeAs('public', $file_name);
            $path = 'http://127.0.0.1:8000/storage/' . $file_name;
            $param = [
                'name' => $request->name,
                'profile' => $request->profile,
                'userLat' => $request->userLat,
                'userLng' => $request->userLng,
                'image' => $path,
                'instagramURL' => $request->instagramURL,
                'twitterURL' => $request->twitterURL
            ];
        }
        DB::table('users')->where('id', $request->id)->update($param);
        return response()->json([
            'message' => 'User updated successfully',
            'data' => $param
        ], 200);
    }
}
