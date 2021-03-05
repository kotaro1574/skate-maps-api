<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FilesController extends Controller
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
        foreach ($request->file as $item) {
            $file_name = time() . '.' . $item->getClientOriginalName();
            $item->storeAs('public', $file_name);
            $path = 'storage/' . $file_name;
            $param = [
                'post_id' => $request->post_id,
                'path' => $path,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            DB::table('files')->insert($param);
        }
        return response()->json([
            'message' => 'files created successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
