<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

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
    public function getSubjectsFor($courseId)
    {
        $subjects = Subject::where('course_id', $courseId)->get();
        if ($subjects) {
            return $subjects;
        } else {
            return  [
                'success' => false,
                'message' => "Could not find subjects for this course",
            ];
        }
    }
    /**
     * Display a listing of the resource.
     * @param  int  $grade
     * @return \Illuminate\Http\Response
     */
    public function getSubjectDetail($stdId)
    {
        $subjects = Subject::where('subject_id', $stdId)->get();
        if ($subjects) {
            return $subjects;
        } else {
            return  [
                'success' => false,
                'message' => "Could not find subject detail",
            ];
        }
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
