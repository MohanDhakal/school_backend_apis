<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        // $posts=Post::all(
        //     [
        //     'post_id',
        //     'user_id',
        //     'title',
        //     'body',
        //     'slugs',
        //     'cover_image',
        //     'updated_at'
        //     ]
        // );
    
        $posts = Post::paginate(5, [
            'post_id',
            'user_id',
            'title',
            'body',
            'slugs',
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
        $image_uri = "http://localhost:8000/storage/posts/download.jpeg";
        if ($request->hasFile('image')) {
            $path = Storage::putFile('public/posts', $request->file('image'));
            $url = Storage::url($path);
            $image_uri = config('app.url') . $url;
        } else {
            Log::info("no image available");
        }

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
    public function author($id)
    {
        $user = DB::table('users')
            ->where('id', '=', $id)
            ->get()->first();
        if ($user == null) {
            return [
                'results:' => "empty"
            ];
        }
        return [
            "id"=>$user->id,
            "name"=> $user->name,
            "email"=>$user->email,
        ];
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $post = Post::find($id);
        if ($post != null) {
            Post::where("post_id", $id)->update([
                "title" => $request->input("title"),
                "body" => $request->input('body')
            ]);

            return [
                "success" => true,
                "message" => "post has been updated"
            ];
        }
        return [
            "success" => false,
            "message" => "post cannot be updated",
            "response" => $post
        ];
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
                "message" => "post does not exists",
                "code" => 401
            ];
        }
        $post->delete();
        return [
            "success" => true,
            "message" => "post deleted"
        ];
    }

    

}
