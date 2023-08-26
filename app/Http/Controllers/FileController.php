<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class FileController extends Controller
{
    //
    public function download()
    {
         $filepath = request()->query("file_path");
         Log::info(public_path("storage/$filepath"));
         return response()->download(public_path("storage/$filepath"));
    }

    public function index($directory)
    {
        $files = Storage::disk('public')->allFiles("files/$directory");
       return response()->json([
            "data"=>$files
        ]);
    }
}
