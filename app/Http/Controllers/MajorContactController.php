<?php

namespace App\Http\Controllers;

use App\Models\MajorContact;
use App\Models\Staff;
use Illuminate\Http\Request;

class MajorContactController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = MajorContact::all()->sortBy('position', SORT_NUMERIC);
        $staffIds = $rows->pluck('staff_id');
        $staffDetails = Staff::whereIn('id', $staffIds)->get()->keyBy('id');
        // Attach the staff details to the corresponding rows
        $rowsWithStaffDetails = $rows->map(function ($row) use ($staffDetails) {
            $row->staff_detail = $staffDetails->get($row->staff_id);
            return $row;
        });
        return $rowsWithStaffDetails;    
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $created = MajorContact::create($request->all());
        if ($created) {
            $response = [
                'success' => true,
                'message' => "Major contact added successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error occured, please contact administrator!",
        ];

    }
            /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deleted = MajorContact::destroy($id);
        if ($deleted) {
            return [
                "success" => true,
                "message" => "Major Contact deleted sucessfully"
            ];
        }
        return [
            "success" => false,
            "message" => "contact couldn't be deleted!"
        ];
    }

}
