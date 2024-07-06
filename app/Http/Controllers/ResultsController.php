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
        $subject_id = $request->input('subject_id');
        $marks_type = $request->input('marks_type');
        $grade = 'NG';
        $marks =   $request->input('marks');
        $percentage = 0;
        $subject = Subject::find($subject_id);

        if ($marks_type == "IN") {
            $percentage = ($marks / $subject->IN_W) * 100;
        } else if ($marks_type == "TH") {
            $percentage = ($marks / $subject->TH_W) * 100;
        }
        $grade = ResultsController::find_grade($percentage);

        $request->merge(['grade' => $grade]);

        $created = Result::create($request->all());

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
     * update an existing resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function update(Request $request, $id)
    {
        Log::info($request->all());
        $result = Result::find($id);
        // Check if the record exists
        if (!$result) {
            return response()->json(['message' => 'Result not found'], 404);
        }
        $subject_id = $request->input('subject_id');
        $marks_type = $request->input('marks_type');
        $grade = 'NG';
        $marks =  $request->input('marks');      
        $percentage = 0;
        $subject = Subject::find($subject_id);
        if ($marks_type == "IN") {
            $percentage = ($marks / $subject->IN_W) * 100;
        } else if ($marks_type == "TH") {
            $percentage = ($marks / $subject->TH_W) * 100;
        }
        $grade = ResultsController::find_grade($percentage);
        $request->merge(['grade' => $grade]);
        Log::info($request->input("marks"));
        $updated = $result->update($request->all());
        if ($updated) {
            $response = [
                'success' => true,
                'message' => "Result updated successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error occured, please contact administrator!",
        ];
    }
    /**
     * Return a string.
     *
     * @return string
     */
    public  function find_grade($percent)
    {

        switch ($percent) {
            case $percent >= 90:
                return 'A+';
            case $percent < 90 && $percent >= 80:
                return 'A';
            case $percent < 80 && $percent >= 70:
                return 'B+';

            case $percent < 70 && $percent >= 60:
                return 'B';

            case $percent < 60 && $percent >= 50:
                return 'C+';

            case $percent < 50 && $percent >= 40:
                return 'C';

            case $percent < 40 && $percent >= 35:
                return 'D';
            default:
                // Default case when the value does not match any of the cases
                return 'NG';
        }
    }
    /**
     * Calculate and return a float value.
     *
     * @return float
     */
    public  function find_GP($grade)
    {

        switch ($grade) {
            case 'A+':
                return 4.0;
            case 'A':
                return 3.6;
            case 'B+':
                return 3.2;
            case 'B':
                return 2.8;
            case 'C+':
                return 2.4;
            case 'C':
                return 2.0;
            case 'D':
                return 1.6;
            default:
                return 0.0;
        }
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_result(Request $request)
    {
        $student_id = $request->input("student_id");
        $exam_id = $request->input("exam_id");

        $results = Result::where('student_id', $student_id)
            ->where('exam_id', $exam_id)
            ->get();
        for ($i = 0; $i < count($results); $i++) {
            $result = $results[$i];
            try {
                $sub_id = $result->subject_id;
                $subject = Subject::where('subject_id', $sub_id)->first();
                $result->subject_name = $subject->subject_name;
                $totalPercentage= $subject->TH_W+ $subject->IN_W;                
                if($result->marks_type=="TH"){
                    $result->credit=   ( $subject->total_credit) * ($subject->TH_W/$totalPercentage);
                }else if($result->marks_type=="IN"){
                    $result->credit=   ( $subject->total_credit) *  ($subject->IN_W/$totalPercentage);
                }
               $result->grade_point= ResultsController::find_GP($result->grade);
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

    /**
     * Add resrouce after calculation.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function add_gpa(Request $request)
    {
        $student_id = $request->input("student_id");
        $exam_id = $request->input("exam_id");
        $results = Result::where("student_id", $student_id)
            ->where('exam_id', $exam_id)
            ->get();
        $aggregateCredit = 0.1;
        $aggregateGP = 0.1;
        $failed = false;

        for ($i = 0; $i < count($results); $i++) {
            $result = $results[$i];
            if ($result->grade == "NG") {
                $failed = true;
                break;
            }
            try {
                $sub_id = $result->subject_id;
                $subject = Subject::where('subject_id', $sub_id)->get()->first();
                $result->subject_name = $subject->subject_name;
                if ($result->marks_type == "IN") {
                    $result->credit = ($subject->IN_W / ($subject->TH_W + $subject->IN_W)) * $subject->total_credit;
                    $aggregateCredit += $result->credit;
                    $sub_gp = ResultsController::find_GP($result->grade);
                    $aggregateGP += ($sub_gp * $result->credit);
                } else if ($result->marks_type == "TH") {
                    $result->credit = ($subject->TH_W / ($subject->TH_W + $subject->IN_W)) * $subject->total_credit;
                    $aggregateCredit += $result->credit;
                    $sub_gp = ResultsController::find_GP($result->grade);
                    $aggregateGP += ($sub_gp * $result->credit);
                }
            } catch (\Throwable $th) {
                Log::error("Exception Occured" . $th->getMessage());
            }
        }
        if ($results == null) {
            return [
                'results:' => "empty"
            ];
        }
        if ($failed) {
            return [
                'CGPA:' => 0
            ];
        }
        return   [
            'CGPA:' => number_format($aggregateGP / $aggregateCredit, 2)
        ];
    }
}
