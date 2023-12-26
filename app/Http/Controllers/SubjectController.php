<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        return $subjects;
    }

    /**
     * Display a listing of the resource.
     * @param  int  $grade
     * @return \Illuminate\Http\Response
     */
    public function all($grade)
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $created = Subject::create($request->all());
        if ($created) {
            $response = [
                'success' => true,
                'message' => "subject added successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error occured, please contact administrator",
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
        // $student = Student::find($id);
        // if ($student == null) {
        //     return [
        //         "success" => false,
        //         "message" => "student does not exists"
        //     ];
        // }
        // $student->delete();
        // return [
        //     "success" => true,
        //     "message" => "student deleted"
        // ];
    }
}
