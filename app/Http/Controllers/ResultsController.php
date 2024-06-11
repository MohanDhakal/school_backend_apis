<?php

namespace App\Http\Controllers;
use App\Models\Result;
use App\Models\Subject;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class ResultsController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $created= Result::create($request->all());
        if ($created) {
            $response = [
                'success' => true,
                'message' => "Result added successfully",
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_result(Request $request)
    {
        $student_id =$request->input("student_id");
        $academic_year=$request->input("academic_year");
        $grade=$request->input("grade");
        $term=$request->input("term");
        
        
        $results = Result::where('student_id', $student_id)
                    ->where('academic_year', $academic_year)
                    ->where('grade', $grade)
                    ->where('term', $term)
                    ->get();
                for ($i=0; $i <count($results) ; $i++) { 
                    $result=$results[$i];
                    try {
                        $sub_id= $result->subject_id;
                        $subject_name = Subject::where('subject_id',$sub_id)->pluck('subject_name');
                        $result->subject_name=$subject_name[0];                    
                       } catch (\Throwable $th) {
                        Log::error("Exception Occured");
                                          }
                }
        if ($results == null) {
            return [
                'results:' => "empty"
            ];
        }
        return $results;
    }



}
