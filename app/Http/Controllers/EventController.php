<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events=Event::latest()->take(3)->get();      
        return $events;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if ($request->has("image")) {
            $path = Storage::putFile('public/events', $request->file('image'));
            $url = Storage::url($path);
            $image_uri = config('app.url')  . $url;
            $request->merge(['event_banner' => $image_uri]);
        }
        $data = $request->except(['image']);
        $created = Event::create($data);
        if ($created) {
            $response = [
                'success' => true,
                'message' => "Event created successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error occured, please contact administrator!",
        ];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,int $id){
        if ($request->has("image")) {
            $path = Storage::putFile('public/events', $request->file('image'));
            $url = Storage::url($path);
            $image_uri = config('app.url')  . $url;
            $request->merge(['event_banner' => $image_uri]);
        }
        $data = $request->all();
        $current_event = Event::find($id);
        if ($current_event) {
            $result = $current_event->update($data);
            return response()->json(['message' => 'Event updated successfully', 'result' => $result], 200);
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
    public function delete($id)
    {
        $deleted = Event::destroy($id);
        if ($deleted) {
            return [
                "success" => true,
                "message" => "Event deleted sucessfully"
            ];
        }
        return [
            "success" => false,
            "message" => "Event couldn't be deleted!"
        ];
    }

    
}
