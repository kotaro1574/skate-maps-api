<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function post(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:12',
        ]);
        $user = DB::table('users')->where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'auth' => false,
                'message' => 'メールアドレスかパスワードが間違っています'
            ], 200);
        }
        if (Hash::check($request->password, $user->password)) {
            return response()->json(['auth' => true], 200);
        } else {
            return response()->json([
                'auth' => false,
                'message' => 'メールアドレスかパスワードが間違っています'
            ], 200);
        }
    }
}
