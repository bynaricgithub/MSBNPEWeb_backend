<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    public function uploadChunk(Request $request)
    {
        $origin = $request->header('Origin') ?? $request->header('Referer');

        // Define your allowed domains
        $allowedDomains = [
            Config::get('constants.FRONTURL'),
            'https://csn.bynaricexam.com',
        ];

        // Check if origin is allowed
        if (! $origin || ! collect($allowedDomains)->contains(fn ($domain) => str_starts_with($origin, $domain))) {
            return response()->json(['error' => 'Unauthorized domain'], 403);
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'file' => 'required',
            'chunk' => 'required',
            'totalChunks' => 'required',
            'filename' => 'required',
            'timestamp' => 'required',
            'storagePath' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $file = $request->file('file');
        $chunk = $request->input('chunk');
        $totalChunks = $request->input('totalChunks');
        $filename = $request->input('filename');
        $timestamp = $request->input('timestamp');
        $storagePath = $request->input('storagePath');

        // replacing spaces with underscore
        $filename = str_replace(' ', '_', $filename);

        // making storage folder path for chunks
        $folderPath = public_path('data/temp/'.$timestamp.'_'.$filename);

        if (! file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // $chunkPath = $folderPath . '/' . $filename . '.part' . $chunk;
        // Store the chunk
        $file->move($folderPath, $filename.'.part'.$chunk);

        if ($chunk == $totalChunks - 1) {
            $finalFilePath = $folderPath.'/'.$filename;

            // Combine all the chunks
            $finalFile = fopen($finalFilePath, 'wb');
            for ($i = 0; $i < $totalChunks; $i++) {
                $part = $folderPath.'/'.$filename.'.part'.$i;
                $chunkData = file_get_contents($part);
                fwrite($finalFile, $chunkData);
                unlink($part);  // Delete the chunk after appending it
            }
            fclose($finalFile);

            $targetFolder = public_path('data/'.$storagePath);

            if (! file_exists($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }

            // Attach timestamp
            $finalTargetPath = $targetFolder.'/'.$timestamp.'_'.$filename;

            // move it to another folder
            rename($finalFilePath, $finalTargetPath);

            // Remove the timestamped temporary folder
            rmdir($folderPath);

            return response()->json([
                'message' => 'File uploaded successfully!',
                'filePath' => $storagePath.'/'.$timestamp.'_'.$filename,
            ]);
        }

        return response()->json(['message' => 'Chunk uploaded successfully']);
    }
}
