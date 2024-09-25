<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category($id)
    {
        $post = Category::find($id);
        return $post;;
    }
    public function index()
    {
        $categories = Category::all();
        return $categories;;
    }
    public function store(Request $request)
    {
        $created =  Category::create($request->all());
        if ($created) {
            $response = [
                'success' => true,
                'message' => "new category created successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error creating new category",
        ];
    }
}
