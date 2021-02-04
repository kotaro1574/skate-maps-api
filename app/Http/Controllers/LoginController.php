<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function post(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();
        if (Hash::check($request->password, $user->password)) {
            return response()->json(['auth' => true], 200);
        } else {
            return response()->json(['auth' => false], 200);
        }
    }
}