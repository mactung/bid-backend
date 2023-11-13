<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
        ]);

        // Store the uploaded file
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        // Perform any additional logic (e.g., database entry, Cloudflare integration)

        return response()->json(['message' => 'Image uploaded successfully']);
    }

    public function s3Upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();

        // Upload the image to S3
        Storage::disk('s3')->put($imageName, file_get_contents($image));

        // Optionally, you can store the S3 URL or perform additional logic

        return response()->json(['message' => 'Image uploaded to S3 successfully']);
    }
}
