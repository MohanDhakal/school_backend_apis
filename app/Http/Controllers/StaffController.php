<?php

namespace App\Http\Controllers;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $staffs = Staff::paginate(5,[
            'id',
            'full_name',
            'address',
            'email',
            'level',
            'image_uri',
            'post',
            'is_active'            
        ]);
        return $staffs;  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = Storage::putFile('staffs', $request->file('image'));
        $url = Storage::url($path);
        $image_uri = config('app.url') . '/' . $url;

        $request->merge(['image_uri' => $image_uri]);
        $data = $request->except(['image']);
        
        $data['is_active'] = $request['is_active'] === 'true';


        $created=Staff::create($data);
        // Log::info($created);
        if($created){
            $response= [
                'success'=>true,
                'message'=>"staff added successfully",
            ];
            return $response;

        }
        return  [
            'success'=>false,
            'message'=>"error occured, please contact administrator",
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
        $student = DB::table('students')->find($id,
        [
            'id',
            'full_name',
            'address',
            'email',
            'level',
            'image_uri',
            'post',
            'roll_number',
            'dob',
            'guardian_contact',
            'is_active',
            'joined_at',
            'grade',
            'current_rank',
            'major_subject'
       ]);
       if($student==null){
        return [
        'results:'=>"empty"
        ];
       }
    return $student;
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
        //
    }
}
