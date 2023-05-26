<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDO;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(5, [
            'post_id',
            'user_id',
            'title',
            'body',
            'cover_image',
            'updated_at'
        ]);
        return $posts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $path = Storage::putFile('posts', $request->file('image'));
        $url = Storage::url($path);
        $image_uri = config('app.url') . '/' . $url;
        $id = Auth::user()->id;
        $request->merge(['cover_image' => $image_uri, 'user_id' => $id]);
        // print_r($request->all());
        $data = $request->except(['image']);
        $created = Post::create($data);
        if ($created) {
            $response = [
                'success' => true,
                'message' => "new post added successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error occured, please contact administrator",
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $post = DB::table('posts')
            ->where('post_id', '=', $id)
            ->get()->first();
        if ($post == null) {
            return [
                'results:' => "empty"
            ];
        }
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        $post = Post::find($id);
        if ($post == null) {
            return [
                "success" => false,
                "message" => "post does not exists"
            ];
        }
        $post->delete();
        return [
            "success" => true,
            "message" => "post deleted"
        ];
    }
}
