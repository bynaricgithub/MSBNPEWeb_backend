<?php

namespace App\Http\Controllers;

use App\Models\VideoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoGalleryController extends Controller
{
    public function index()
    {
        try {
            $result = VideoGallery::orderBy('order_id')->get();

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'VideoGallery list fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error fetching video gallery: '.$e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'file' => 'required|string',
                'category' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $lastId = VideoGallery::max('id') ?? 0;

            $new = VideoGallery::create([
                'title' => $request->title,
                'file' => $request->file,
                'category' => $request->category,
                'order_id' => $lastId + 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Video added successfully',
                'data' => $new,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error adding video: '.$e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:video_galleries,id',
                'title' => 'required|string|max:255',
                'file' => 'required|string',
                'category' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $video = VideoGallery::find($request->id);
            $video->title = $request->title;
            $video->file = $request->file;
            $video->category = $request->category;
            $video->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Video updated successfully',
                'data' => $video,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error updating video: '.$e->getMessage(),
            ], 500);
        }
    }

    public function disable(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:video_galleries,id',
                'status' => 'required|in:0,1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            VideoGallery::where('id', $request->id)->update(['status' => $request->status]);

            return response()->json([
                'status' => 'success',
                'message' => $request->status == 1 ? 'Enabled successfully' : 'Disabled successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error changing status: '.$e->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:video_galleries,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            VideoGallery::where('id', $request->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Video deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error deleting video: '.$e->getMessage(),
            ], 500);
        }
    }
}
