<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spots = Post::orderBy('id', 'desc')->get();
        return response()->json([
            'message' => 'OK',
            'data' => $spots
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = Carbon::now();
        $param = [
            "spotName" => $request->spotName,
            "spotLat" => $request->spotLat,
            "spotLng" => $request->spotLng,
            "spotImg" => $request->spotImg,
            "created_at" => $now,
            "updated_at" => $now,
        ];
        DB::table('posts')->insert($param);
        return response()->json([
            'message' => 'Post created successfully',
            'data' => $param
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $spot = Post::where('id', $post->id)->first();
        return response()->json($spot, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $param = [
            'spotName' => $request->spotName,
            'spotImg' => $request->spotImg,
            'spotLat' => $request->spotLat,
            'spotLng' => $request->spotLng
        ];
        DB::table('posts')->where('id', $request->spotId)->update($param);
        return response()->json([
            'message' => 'Post updated seccessfully',
            'data' => $param
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $item = Post::where('id', $post->id)->delete();
        if ($item) {
            return response()->json(
                ['message' => 'Spot deleted successfully'],
                200
            );
        } else {
            return response()->json(
                ['message' => 'Spot not found'],
                404
            );
        }
    }
}
