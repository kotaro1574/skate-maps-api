<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = Comment::where('post_id', $request->post_id)->get();
        return response()->json([
            'message' => 'OK',
            'data' => $comments
        ]);
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
            'post_id' => $request->post_id,
            'user_id' => $request->user_id,
            'comment' => $request->comment,
            'commentImg' => $request->commentImg,
            'created_at' => $now,
            'updated_at' => $now
        ];
        DB::table('comments')->insert($param);
        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $param
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment, Request $request)
    {
        $comment = Comment::where('id', $comment->id)->first();
        $user_id = $comment->user_id;
        $user = DB::table('users')->where('id', (int)$user_id)->first();
        $commentData = [
            'comment' => $comment,
            'user' => $user
        ];
        if ($commentData) {
            return response()->json($commentData, 200);
        } else {
            return response()->json('null', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $item = Comment::where('id', $comment->id)->delete();
        if ($item) {
            return response()->json(
                ['message' => 'Comment deleted successfully'],
                200
            );
        } else {
            return response()->json(
                ['message' => 'Comment not found'],
                404
            );
        }
    }
}
