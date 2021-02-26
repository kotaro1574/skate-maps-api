<?php

namespace App\Http\Controllers;

use App\Models\BestTrick;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BestTrickController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $file_name = time() . '.' . $request->file->getClientOriginalName();
        $request->file->storeAs('public', $file_name);
        $path = 'storage/' . $file_name;

        $param = [
            'post_id' => $request->spotId,
            'user_id' => $request->userId,
            'path' => $path,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('best_tricks')->insert($param);
        return response()->json([
            'message' => 'BestTrick created successfully',
            'data' => $param
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BestTrick  $bestTrick
     * @return \Illuminate\Http\Response
     */
    public function show(BestTrick $bestTrick)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BestTrick  $bestTrick
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BestTrick $bestTrick)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BestTrick  $bestTrick
     * @return \Illuminate\Http\Response
     */
    public function destroy(BestTrick $bestTrick)
    {
        //
    }
}
