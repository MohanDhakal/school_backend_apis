<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
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
        $subjects = Subject::all()->map(function ($subject) {
            // Assuming `grade_id` is the foreign key in the Subject model
            $grade = Grade::find($subject->class_id);
            // If a corresponding grade is found, add the class_num to the subject
            if ($grade) {
                $subject->class_num = $grade->class_num;
            }

            return $subject;
        });
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
        $subjects = Subject::where('subject_id', $stdId)->first();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $current_subject = Subject::find($id);
        if ($current_subject) {
            $result = $current_subject->update($data);
            return response()->json(['message' => 'Subject updated successfully', 'result' => $result], 200);
        }
        return  [
            'success' => false,
            'message' => "error occured while updating subject",
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
        $subject = Subject::find($id);
        if ($subject == null) {
            return [
                "success" => false,
                "message" => "subject does not exists"
            ];
        }
        $subject->delete();
        return [
            "success" => true,
            "message" => "subject deleted"
        ];
    }
}
