<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
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
        $album_id = $request->input("folder_id");
        $album = Album::findOrFail($album_id);
        $columnValue = $album->{"name"};
        if ($request->hasFile('images')) {
            // Log::info($columnValue);
            $image = $request->file('images');
            $path = public_path($columnValue);
            $folderPath = str_replace(base_path(), '', $path);
            // $relativePath = str_replace("public/", '', $folderPath);
            $base_url = asset($folderPath);
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();
                $value->move($path, $name);
                $image_uri = $base_url . '/' . $name;
                $updatedUrl = str_replace("public", '/', $image_uri);
                Log::info($updatedUrl);
                $data = [
                    'folder_id' => $album_id, // Replace with the desired ID
                    'image_url' => $updatedUrl, // Replace with the desired folder name
                ];
                $created = Image::create($data);
                if ($created) {
                    Log::info("created successfully");
                }
            }
            return [
                "code" => 200,
                "message" => "image sucessfully created"
            ];
        } else {
            Log::info("no image data available");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $images = DB::table('images')
            ->where('folder_id', '=', $id)
            ->get();
        return $images;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('images')
            ->where('folder_id', '=', $id)
            ->delete();
        $album = Album::find($id);
        $album->delete();
        return [
            "success" => true,
            "message" => "album deleted"
        ];
    }
}
