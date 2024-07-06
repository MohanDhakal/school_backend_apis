<?php
namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Exam::all();
        return $courses;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $created = Exam::create($data);
        if ($created) {
            $response = [
                'success' => true,
                'message' => "Exam added successfully."
            ];
            return $response;
        }
    }

    /**
     * Display the specified resource.
     */
    public function getExamsForYear(int $year)
    {
 
        $exams = Exam::where('academic_year', $year)->get();
        return response()->json($exams);
    }

    /**
     * return all academic years
     */
    public function getAcademicYear()
    {
        $academicYears = Exam::distinct()->pluck('academic_year');
        return $academicYears;
       
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
    public function destroy($id)
    {
        $deleted = Exam::destroy($id);

        if ($deleted) {
            return [
                "success" => $deleted,
                "message" => "Exam with ID $id deleted successfully!"
            ];
        } else {
            return [
                "success" => $deleted,
                "message" => "Exam with ID $id cannot be deleted!"
            ];
        }
    }
}
