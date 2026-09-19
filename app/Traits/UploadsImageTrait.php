<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

trait UploadsImageTrait
{
    /**
     * Upload an image and update the model with the image path.
     *
     * @param mixed $model The model instance.
     * @param array $directoryParts Array of directory parts.
     * @param string $imageContent The image content to store.
     * @param string $column The column name to update with the image path.
     * @return void
     */
    public function uploadImage($model, $basePath, $imageContent, $column)
    {
        $directory = "{$model->getTable()}/{$model->id}/";
    
        $timestamp = Carbon::now()->format('Ymd_His');
        $filename = "{$column}-{$timestamp}.webp";
        $imagePath = $directory . $filename;
    
        Storage::disk('public')->makeDirectory($directory);
    

    
        if (isValidBase64Image($imageContent)) {
            $oldImage = $model->{$column};
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            $image = Image::make($this->decodeBase64Image($imageContent))->orientate();
            $image->resize(1600, 1600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::disk('public')->put($imagePath, (string) $image->encode('webp', 82));
    
            $model->{$column} = $imagePath;
            $model->save();
        }
    }
    
    
    

    public function uploadFileAplication($model, array $directoryParts, $imageContent, $fileName, $column = 'image_path')
    {
        // Join the directory parts into a string
        $directory = implode('/', $directoryParts) . '/';

        // Ensure the directory exists
        Storage::disk('public')->makeDirectory($directory);

        // Get list of existing image files
        $existingFiles = Storage::disk('public')->files($directory);

        // Generate a unique filename
        $timeNow = Carbon::now()->format('Ymd_His');
        //$filename = "{$column}-{$timeNow}-{$model->id}.xlsx";

        if (preg_match('/data:(.*?);base64,/', $imageContent, $matches)) {
            $mimeType = $matches[1];  // Lấy loại MIME

            foreach ($existingFiles as $file) {
                Storage::disk('public')->delete($file);
            }
            $imageData = $this->decodeBase64Image($imageContent);
            // Save image to storage
            $file =  preg_replace('/[^a-zA-Z0-9\.]/', '', $fileName);
            $imagePath = $directory . $file;

            Storage::disk('public')->put($imagePath, $imageData);
            $model->{$column} = $imagePath;
            $model->save();
        }
    }

    private function decodeBase64Image($base64String)
    {
        list($type, $data) = explode(';', $base64String);
        list(, $data) = explode(',', $data);
        return base64_decode($data);
    }

    public function uploadFile($model, array $directoryParts, $file, $column = 'file_path')
    {
        // Join the directory parts into a string
        $directory = implode('/', $directoryParts) . '/';

        // Ensure the directory exists
        Storage::disk('public')->makeDirectory($directory);

        // Generate a unique filename
        $extension = $file->getClientOriginalExtension();
        $timeNow = Carbon::now()->format('Ymd_His');
        $filename = "{$column}-{$timeNow}-{$model->id}.{$extension}";

        // Delete existing file if necessary
        $existingFiles = Storage::disk('public')->files($directory);
        foreach ($existingFiles as $existingFile) {
            Storage::disk('public')->delete($existingFile);
        }

        // Save the new file to storage
        $filePath = $directory . $filename;
        $file->storeAs($directory, $filename, 'public');

        // Update model record with file path
        $model->{$column} = $filePath;
        $model->save();
    }
}
