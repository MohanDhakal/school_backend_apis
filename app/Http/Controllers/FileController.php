<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    public function download()
    {
        $filepath = request()->query("file_path");
        return response()->download(public_path("storage/$filepath"));
    }

    public function index($directory)
    {
        $files = Storage::disk('public')->allFiles("files/$directory");
        rsort($files);
        return response()->json([
            "data" => $files
        ]);
    }

    public function upload(Request $request)
    {
        $fileInputName = "file"; // Replace with the name attribute of your file input
        $folder = "files/" . $request->input("folder"); // Specify the folder where you want to store the files

        // Check if a file was uploaded
        if ($request->hasFile($fileInputName)) {
            $file = $request->file($fileInputName);

            // Get the original file name
            $originalFileName = $file->getClientOriginalName();

            // Generate a unique date string (e.g., timestamp)
            $uniqueDate = date('YmdHis');

            // Append the unique date to the original file name
            $fileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $uniqueDate . '.' . $file->getClientOriginalExtension();

            // Specify the storage disk (e.g., 'public' or 's3')
            $disk = 'public';

            // Upload the file to the specified disk and folder
            $filePath = $file->storeAs($folder, $fileName, $disk);

            // Return a JSON response with the file path
            return response()->json(['message' => 'File uploaded successfully', 'file_path' => $filePath], 200);
        }

        // If no file was uploaded, return a JSON error response
        return response()->json(['message' => 'No file uploaded', 'file_path' => null], 400);
    }
    public function deleteFile(Request $request)
    {
        $folder = 'files/' . $request->input("folder"); // Specify the folder name within the 'public' disk
        $disk = 'public';
        $fileNameToDelete = $request->input("file_name"); // Specify the name of the file you want to delete
        // Construct the full file path
        $filePathToDelete = $folder . '/' . $fileNameToDelete;
        Log::info($filePathToDelete);
        // Check if the file exists before attempting to delete it
        if (Storage::disk($disk)->exists($filePathToDelete)) {
            // Delete the file
            Storage::disk($disk)->delete($filePathToDelete);

            // File has been successfully deleted
            return response()->json(['message' => 'File deleted successfully'], 200);
        } else {
            // File not found
            return response()->json(['message' => 'File not found'], 404);
        }
    }   
}
