<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $sortedResults = Staff::orderByRaw('level_int + rank DESC')
            ->orderBy('joined_at', 'ASC')
            ->paginate(5);
        foreach ($sortedResults as $row) {
            $row->dob = LaravelNepaliDate::from($row->dob)->toNepaliDate();
            $row->joined_at = LaravelNepaliDate::from($row->joined_at)->toNepaliDate();
        }
        return $sortedResults;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $sortedResults = Staff::orderByRaw('level_int + rank DESC')
            ->orderBy('joined_at', 'ASC')->get();
        foreach ($sortedResults as $row) {
            $row->dob = LaravelNepaliDate::from($row->dob)->toNepaliDate();
            $row->joined_at = LaravelNepaliDate::from($row->joined_at)->toNepaliDate();
        }
        return $sortedResults;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $path = Storage::putFile('public/staffs', $request->file('image'));
        $url = Storage::url($path);
        $image_uri = config('app.url')  . $url;
        $request->merge(['image_uri' => $image_uri]);
        $data = $request->except(['image']);
        // $dateInBS = str_replace('/', '-', $request['dob']);
        $data['is_active'] = $request['is_active'] === 'true';
      
        $data['dob'] = LaravelNepaliDate::from($data['dob'])->toEnglishDate();
        $data['joined_at'] = LaravelNepaliDate::from($data['joined_at'])->toEnglishDate();
        

        $created = Staff::create($data);
        if ($created) {
            $response = [
                'success' => true,
                'message' => "staff added successfully",
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
        $staffs = DB::table('staff')->find(
            $id
        );
        if ($staffs == null) {
            return [
                'results:' => "empty"
            ];
        }
        return $staffs;
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
        $staff = Staff::find($id);
        if ($staff != null) {
            $newRequest = $request->except(["image"]);
            $newRequest['dob'] = LaravelNepaliDate::from($newRequest['dob'])->toEnglishDate();
            $newRequest['joined_at'] = LaravelNepaliDate::from($newRequest['joined_at'])->toEnglishDate();
            $data['is_active'] = $request['is_active'] === 'true';
            Staff::where("id", $id)->update($newRequest);

            return [
                "success" => true,
                "message" => "staff has been updated"
            ];
        }
        return [
            "success" => false,
            "message" => "staff cannot be updated",
            "response" => $staff
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
        $staff = Staff::find($id);
        if ($staff != null) {
            $deleted = $staff->delete();
            if ($deleted) {
                return [
                    "success" => true,
                    "message" => "staff deleted"
                ];
            }
        }
        return [
            "success" => false,
            "message" => "staff does not exists"
        ];
    }
    public function test()
    {
        $response = [
            'success' => true,
            'message' => "staff added successfully",
        ];
        return $response;
    }
}
