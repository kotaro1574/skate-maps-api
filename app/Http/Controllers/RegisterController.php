<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function post(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|max:12',
            'userLat' => 'required',
            'userLng' => 'required'
        ]);
        $email = DB::table('users')->where('email', $request->email)->first(); 
        if ($email) {
            return response()->json([
                'error' => 'このメールアドレスは、既に登録されています。',
            ], 200);
        } else {
            $now = Carbon::now();
            $hashed_password = Hash::make($request->password);
            $param = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => $hashed_password,
                "userLat" => $request->userLat,
                "userLng" => $request->userLng,
                "created_at" => $now,
                "updated_at" => $now,
            ];
            DB::table('users')->insert($param);
            return response()->json([
                'message' => 'User created successfully',
                'data' => $param
            ], 200);
        }
    }
}
