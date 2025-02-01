<?php

namespace Database\Seeders;

use App\Models\Students;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\PdfToImage\Pdf;

class UpdateStudentImages extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folderPath = public_path('img/uploaded-img/');
        $files = scandir($folderPath);

        foreach ($files as $key => $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $folderPath . '/' . $file;
            $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            // Check if the file exists in the database in any column
            $student = DB::table('old_students')
                ->where('photo', $file)
                ->orWhere('aadhar_card', $file)
                ->orWhere('qualification', $file)
                ->orWhere('signature', $file)
                ->first();

            if (!$student || !file_exists($filePath)) {
                continue;
            }

            // Determine which field this file belongs to
            $columnToUpdate = null;
            if ($student->photo === $file) {
                $columnToUpdate = 'photo';
            } elseif ($student->aadhar_card === $file) {
                $columnToUpdate = 'identity_card';
            } elseif ($student->qualification === $file) {
                $columnToUpdate = 'qualification';
            } elseif ($student->signature === $file) {
                $columnToUpdate = 'signature';
            }

            if (!$columnToUpdate) {
                continue; // Skip if file is not linked to any column
            }

            // Generate a hashed filename to store
            $storedPath = 'students/' . md5(pathinfo($file, PATHINFO_FILENAME)) . '.jpg';

            if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                // Resize the image
                $resizedImage = Image::make($filePath)
                    ->resize(800, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 80); // Convert to JPEG with quality 80%

                // Store the image
                Storage::disk('public')->put($storedPath, $resizedImage);
                echo "{$key} - Stored resized image: $file\n";
            } elseif ($fileExtension === 'pdf') {
                $this->command->info($student->name);
                // Convert PDF to Image
//                try {
//                    $pdf = new Pdf($filePath);
//                    $pdf->setOutputFormat('jpg')->saveImage(public_path($storedPath));
//                    echo "{$key} - Converted PDF to Image: $file\n";
//                } catch (\Exception $e) {
//                    echo "Error converting PDF: {$e->getMessage()}\n";
//                    continue;
//                }
            } else {
                continue; // Skip unsupported file types
            }

            // Update the correct column in the database
            Students::where('name', $student->name)
                ->where('father_name', $student->father_name)
                ->where('mother_name', $student->mother_name)
                ->update([$columnToUpdate => $storedPath]);

            echo "{$key} - Updated database for: $file ($columnToUpdate)\n";
        }
    }
}
