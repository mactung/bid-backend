<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ad
        ]);

        // Store the uploaded file
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(app()->basePath('public/images'), $imageName);

        // Perform any additional logic (e.g., database entry, Cloudflare integration)

        // return response()->json(['message' => 'Image uploaded successfully', 'result' => ]);
    }

    public function s3Upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ad
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();

        $bucket_name        = config('s3.bucket_name');
        $account_id         = config('s3.account_id');
        $access_key_id      = config('s3.access_key_id');
        $access_key_secret  = config('s3.access_key_secret');

        $credentials = new Credentials($access_key_id, $access_key_secret);

        $options = [
            'region' => 'auto',
            'endpoint' => "https://" . $account_id . ".r2.cloudflarestorage.com",
            'version' => 'latest',
            'credentials' => $credentials
        ];

        $s3Client = new S3Client($options);
        $s3Client->putObject([
            'Body'   => fopen($image->path(), 'rb'),
            'Bucket' => $bucket_name,
            'Key' => $imageName,
            'ACL'    => 'public-read',
            'ContentType' => $image->getClientMimeType(),
        ]);

        // Upload the image to S3
        // Storage::disk('s3')->put($imageName, file_get_contents($image));

        // Optionally, you can store the S3 URL or perform additional logic

        return response()->json(['message' => 'Image uploaded to S3 successfully', 
        'result' => 'https://pub-19212772968c431e8ccf8fa3dd37e2be.r2.dev/' . $imageName ]);
    }
}
