<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentContact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return $students;
    }

    /**
     * Display a listing of the resource.
     * @param  int  $grade
     * @return \Illuminate\Http\Response
     */
    public function all($class_id)
    {
        $students = Student::where('class_id', '=', $class_id)
            ->orderBy('roll_number', 'asc')
            ->paginate(5);
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
            // Log::info(config('app.url'));
            // Log::info($url);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addContact(Request $request)
    {

        $data = $request->all();
        $created =  StudentContact::create($data);
        if ($created) {
            $response = [
                'success' => true,
                'message' => "contact added successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "contact could not be added",
        ];
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteContact($id)
    {
        $deleted = StudentContact::destroy($id);
        if ($deleted) {
            return [
                "success" => false,
                "message" => "contact deleted sucessfully"
            ];
        }
        return [
            "success" => true,
            "message" => "contact couldn't be deleted"
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

        $student = DB::table('students')->where('student_id', '=', $id)->first();

        return $student;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getContact($id)
    {

        $student = DB::table('std_contact')->where('student_id', '=', $id)->first();
        if ($student) {
            return $student;
        } else {
            return [];
        }
    }

    public function verify(Request $request)
    {
        $roll_number = $request->input("roll_number");
        $grade = $request->input("class_id");
        $student = Student::where('roll_number', $roll_number)
            ->where('class_id', $grade)
            ->get()->first();
        if ($student == null) {
            return response()->json([
                'error' => 'Student Not Found'
            ], 400);
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
        if ($request->has("image")) {
            $path = Storage::putFile('public/students', $request->file('image'));
            $url = Storage::url($path);
            $image_uri = config('app.url')  . $url;
            $request->merge(['image_uri' => $image_uri]);
        }
        $data = $request->all();
        $data['is_active'] = $request['is_active'] === 'true';
        $current_student = Student::find($id);
        if ($current_student) {
            $result = $current_student->update($data);
            return response()->json(['message' => 'Student updated successfully', 'result' => $result], 200);
        }
        return  [
            'success' => false,
            'message' => "error occured while updating student",
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
    public function toggle($id)
    {
        $resource = Student::findOrFail($id);
        $resource->is_active = !$resource->is_active;
        $resource->save();
        return response()->json([
            'code' => 200,
            'message' => 'Student Status toggled successfully',
            'resource' => $resource,
        ]);
    }
}
