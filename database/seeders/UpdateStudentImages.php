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

            // Skip if file doesn't exist
            if (!file_exists($filePath)) {
                echo "{$key} - File doesn't exist at path: $filePath\n";
                continue;
            }

            // Process the file once
            $storedPath = null;

            if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                // Generate a hashed filename to store
                $storedPath = 'students/' . md5(pathinfo($file, PATHINFO_FILENAME) . time()) . '.jpg';

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
                // Generate a hashed filename to store
                $storedPath = 'students/' . md5(pathinfo($file, PATHINFO_FILENAME) . time()) . '.jpg';

                // PDF handling code commented out
                // $this->command->info("Processing PDF: $file");
                // try {
                //     $pdf = new Pdf($filePath);
                //     $pdf->setOutputFormat('jpg')->saveImage(public_path($storedPath));
                //     echo "{$key} - Converted PDF to Image: $file\n";
                // } catch (\Exception $e) {
                //     echo "Error converting PDF: {$e->getMessage()}\n";
                //     continue;
                // }
            } else {
                echo "{$key} - Skipped unsupported file type: $fileExtension\n";
                continue; // Skip unsupported file types
            }

            if (!$storedPath) {
                continue; // Skip if file processing failed
            }

            // Now find ALL students that use this file and update each one
            // For photo column
            $this->updateStudentsWithFile($file, 'photo', 'photo', $storedPath, $key);

            // For aadhar_card column
            $this->updateStudentsWithFile($file, 'aadhar_card', 'identity_card', $storedPath, $key);

            // For qualification column
            $this->updateStudentsWithFile($file, 'qualification', 'qualification', $storedPath, $key);

            // For signature column
            $this->updateStudentsWithFile($file, 'signature', 'signature', $storedPath, $key);
        }
    }

    /**
     * Update all students that use a specific file in a specific column
     *
     * @param string $file Original filename
     * @param string $oldColumn Column name in old_students table
     * @param string $newColumn Column name in students table
     * @param string $storedPath New path to the stored file
     * @param int $key Processing index for logging
     * @return void
     */
    private function updateStudentsWithFile(string $file, string $oldColumn, string $newColumn, string $storedPath, int $key): void
    {
        // Get all students who have this file in the specified column
        $matchingStudents = DB::table('old_students')
            ->where($oldColumn, $file)
            ->get();

        if ($matchingStudents->isEmpty()) {
            return;
        }

        $updateCount = 0;

        // Update each student individually
        foreach ($matchingStudents as $student) {
            $updated = Students::where('name', $student->name)
                ->where('father_name', $student->father_name)
                ->where('mother_name', $student->mother_name)
                ->update([$newColumn => $storedPath]);

            $updateCount += $updated;
        }

        if ($updateCount > 0) {
            echo "{$key} - Updated {$updateCount} students with file: $file ($oldColumn -> $newColumn)\n";
        }
    }
}
