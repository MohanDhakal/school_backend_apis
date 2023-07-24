<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($grade)
    {
        $students = Student::where('grade', '=', $grade)->paginate(5);
        return $students;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has("image")) {
            $path = Storage::putFile('public/students', $request->file('image'));
            $url = Storage::url($path);
            $image_uri = config('app.url')  . $url;   
            $request->merge(['image_uri' => $image_uri]);    
        }
        $data = $request->except(['image']);
        $data['is_active'] = $request['is_active'] === 'true';
        $created = Student::create($data);
        if ($created) {
            $response = [
                'success' => true,
                'message' => "student added successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error occured, please contact administrator",
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $student = DB::table('students')->where('student_id', '=', $id )->first();  
            if($student==null){
            return [
            'results:'=>"empty"
            ];
       }
    return $student;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        if ($student == null) {
            return [
                "success" => false,
                "message" => "student does not exists"
            ];
        }
        $student->delete();
        return [
            "success" => true,
            "message" => "student deleted"
        ];   
    
    }
}
