<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    /**
     * Store a newly created resource in storage.  
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $created = Course::create($data);
        if ($created) {
            $response = [
                'success' => true,
                'message' => "course added successfully."
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "Could not add course."
        ];
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        return $courses;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Course::destroy($id);

        if ($deleted) {
            return [
                "success" => true,
                "message" => "Course with ID $id deleted successfully!"
            ];
        } else {
            return [
                "success" => false,
                "message" => "Course with ID $id cannot be deleted!"
            ];
        }
    }
}
