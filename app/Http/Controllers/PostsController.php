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
        $request->validate([
            'spotName' => 'required|max:150',
            'spotText' => 'required|max:500',
            'spotType' => 'required',
            'spotLat' => 'required',
            'spotLng' => 'required',
        ]);
        $now = Carbon::now();
        $spotType = serialize($request->spotType);
        $param = [
            'user_id' => $request->userId,
            'spotName' => $request->spotName,
            'spotText' => $request->spotText,
            'spotType' => $spotType,
            'spotLat' => $request->spotLat,
            'spotLng' => $request->spotLng,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        DB::table('posts')->insert($param);
        $item = DB::table('posts')->orderBy('id', 'desc')->first();
        return response()->json([
            'message' => 'Post created successfully',
            'data' => $item
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
        $type = unserialize($spot->spotType);
        $user_id = $spot->user_id;
        $image = DB::table('files')->where('post_id', $post->id)->get();
        $user = DB::table('users')->where('id', (int)$user_id)->first();
        $like = DB::table('likes')->where('post_id', $post->id)->get();
        $comment = DB::table('comments')->where('post_id', $post->id)->get();
        $commentData = array();
        if (empty($comment->toArray())) {
            $spotData = [
                'spot' => $spot,
                'image' => $image,
                'user' => $user,
                'like' => $like,
                'comments' => $commentData,
                'type' => $type
            ];
            return response()->json($spotData, 200);
        }
        foreach ($comment as $value) {
            $commentUser = DB::table('users')->where('id', $value->user_id)->first();
            $comments = [
                'comment' => $value,
                'commentUser' => $commentUser
            ];
            array_push($commentData, $comments);
        }
        $spotData = [
            'spot' => $spot,
            'image' => $image,
            'user' => $user,
            'like' => $like,
            'comments' => $commentData,
            'type' => $type
        ];
        return response()->json($spotData, 200);
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
        $request->validate([
            'spotName' => 'required|max:255',
            'spotText' => 'required|max:500',
            'spotType' => 'required',
            'spotLat' => 'required',
            'spotLng' => 'required',
        ]);
        $spotType = serialize($request->spotType);
        $param = [
            'spotName' => $request->spotName,
            'spotText' => $request->spotText,
            'spotType' => $spotType,
            'spotLat' => $request->spotLat,
            'spotLng' => $request->spotLng
        ];
        DB::table('posts')->where('id', $post->id)->update($param);
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
