<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    //
    public function download()
    {
        $filepath = request()->query("file_path");
        // return public_path($filepath);
        return response()->download(public_path("storage/$filepath"));
    }
    public function index($directory)
    {
        $files = Storage::disk('public')->allFiles("files/$directory");
        return $files;
    }
}
