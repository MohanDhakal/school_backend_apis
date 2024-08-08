<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->has("image")) {
            $path = Storage::putFile('public/testimonials', $request->file('image'));
            $url = Storage::url($path);
            $image_uri = config('app.url')  . $url; 
            $request->merge(['image_uri' => $image_uri]);
        }
        $data = $request->except(['image']);
        $data['is_active'] = $request['is_active'] === 'true';
        $created = Testimonial::create($data);
        if ($created) {
            $response = [
                'success' => true,
                'message' => "Testimonial added successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error occured, please contact administrator",
        ];
    }
      /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::all()->sortBy('rank');;
        return $testimonials;
    }
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deleted = Testimonial::destroy($id);
        if ($deleted) {
            return [
                "success" => true,
                "message" => "Testimonial deleted sucessfully"
            ];
        }
        return [
            "success" => false,
            "message" => "contact couldn't be deleted"
        ];
    }

}
