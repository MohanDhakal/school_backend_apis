<?php

namespace App\Http\Controllers;

use App\Models\Queries;
use Illuminate\Http\Request;

class QueriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $feedbacks = Queries::latest() // This sorts by the created_at column by default, or you can specify a column
            ->take(10)
            ->get(['id', 'name', 'email', 'message']);
        return $feedbacks;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created = Queries::create($request->all());
        if ($created) {
            $response = [
                'success' => true,
                'message' => "queries received successfully",
            ];
            return $response;
        }
        return  [
            'success' => false,
            'message' => "error occured, please contact administrator!",
        ];
    }
}
