<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateCenterImages extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folderPath = public_path('img/uploaded-img/');
        $files = scandir($folderPath);

        foreach ($files as $file) {
            // Skip '.' and '..'
            if ($file === '.' || $file === '..') {
                continue;
            }
            // Check if the file name exists in the database
            $imageExists = DB::table('old_users')->where('user_logo', $file)->whereIn('role', ['Center','Admin'])->first();
            if ($imageExists) {
                $sourcePath = $folderPath . '/' . $file;

                // Ensure the file exists in the folder
                if (file_exists($sourcePath)) {
                    // Resize the image using Intervention Image
                    $resizedImage = Image::make($sourcePath)
                        ->resize(800, 600, function ($constraint) {
                            $constraint->aspectRatio(); // Maintain aspect ratio
                            $constraint->upsize();     // Prevent upsizing
                        })
                        ->encode('jpg', 25); // Convert to JPEG and reduce quality to 80%
                    // Save the resized image to Laravel's storage (public disk)
                    $storedPath = 'centers/' . md5(pathinfo($file, PATHINFO_FILENAME)) . '.jpg'; // Save as JPG
                    Storage::disk('public')->put($storedPath, $resizedImage);
                    User::where('name',$imageExists->name)->update(['profile_image' => $storedPath]);
                    echo "Stored resized image: $file\n"; // Log successful storage
                }
            }
        }
    }
}
