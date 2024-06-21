<?php

namespace App\Http\Controllers;
use App\Models\Grade;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Grade::all();
        return $classes;        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created = Grade::create($request->all());
        if ($created) {
            $response = [
                'success' => true,
                'message' => "Grade added successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error occured, please contact administrator!",
        ];
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $deleted = Grade::destroy($id);

        if ($deleted) {
            return [
                "success" => true,
                "message" => "Grade with ID $id deleted successfully!"
            ];
        } else {
            return [
                "success" => false,
                "message" => "Grade with ID $id cannot be deleted!"
            ];
        }
    }
}
