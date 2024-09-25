<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::select(
            'id',
            'user_id',
            'title',
            'body',
            'category_id',
            'cover_image',
            'updated_at',
            'author',
            'date'
        )->orderBy('updated_at', 'desc')->paginate(3);
        return $blogs;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function forPage(Request $request)
    {
        $pageNumber = $request->query('page_number');
        $blogs = Blog::select(
            'id',
            'user_id',
            'title',
            'body',
            'category_id',
            'cover_image',
            'updated_at',
            'author',
            'date',
        )->orderBy('updated_at', 'desc')->forPage($pageNumber, 3)->get();
        return $blogs;
    }
    /**
     * Display a listing of the resource for a particular category
     *
     * @return \Illuminate\Http\Response
     */
    public function my_blog(Request $request, $categoryId)
    {

        $pageNumber = $request->input('page', 1); // Default to page 1 if not provided

        // Use paginate to get the pagination metadata
        $blogs = Blog::select(
            'id',
            'user_id',
            'title',
            'body',
            'category_id',
            'cover_image',
            'updated_at',
            'author',
            'date',
        )->where('category_id', $categoryId)
            ->orderBy('updated_at', 'desc')
            ->paginate(3, ['*'], 'page', $pageNumber);
        // Return the blogs with pagination info
        return response()->json([
            'current_page' => $blogs->currentPage(),
            'first_page' => 1,
            'last_page' => $blogs->lastPage(),
            'total_pages' => $blogs->lastPage(), // Same as last page
            'total_items' => $blogs->total(), // Total number of items
            'per_page' => $blogs->perPage(),
            'data' => $blogs->items(), // The actual data for the current page
            // Items per page
        ]);
    }
    /**
     * Display a listing of the resource for a particular category
     *
     * @return \Illuminate\Http\Response
     */
    public function blogs_except(Request $request, $categoryId)
    {
        $exceptId = $request->input('except_id', 1);

        // Use paginate to get the pagination metadata
        $blogs = Blog::select(
            'id',
            'user_id',
            'title',
            'body',
            'category_id',
            'cover_image',
            'updated_at',
            'author',
            'date',
        )->where('category_id', $categoryId)
            ->where('id', '!=', $exceptId)
            ->orderBy('updated_at', 'desc')
            ->take(5) // Limit to 5 posts
            ->get();
        return $blogs;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function last()
    {

        // Retrieve the last page's blogs
        $blogsOnLastPage = Blog::select('id', 'user_id', 'title', 'body', 'category_id', 'cover_image', 'updated_at', 'author', 'date')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get(); // Pass the last page number

        return $blogsOnLastPage;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = Storage::putFile('public/blogs', $request->file('image'));
            $url = Storage::url($path);
            $image_uri = config('app.url') . $url;
        } else {
            Log::info("no image available");
        }

        $id = Auth::user()->id;
        $request->merge(['cover_image' => $image_uri, 'user_id' => $id]);
        // print_r($request->all());
        $data = $request->except(['image']);
        $created = Blog::create($data);
        if ($created) {
            $response = [
                'success' => true,
                'message' => "new blog post added successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error adding blog",
        ];
    }
    public function writer($id)
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
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
        ];
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
        $post = Blog::find($id);
        if ($post != null) {
            Blog::where("id", $id)->update([
                "title" => $request->input("title"),
                "body" => $request->input('body'),
                "author" => $request->input('author'),
                "date" => $request->input('date'),
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
    public function show($id)
    {
        $post = Blog::find($id);
        return $post;
    }
    public function destroy($id)
    {

        $post = Blog::find($id);
        if ($post == null) {
            return [
                "success" => false,
                "message" => "Blog Post does not exists",
                "code" => 401
            ];
        }
        $post->delete();
        return [
            "success" => true,
            "message" => "Blog post deleted sucessfully!"
        ];
    }
}
