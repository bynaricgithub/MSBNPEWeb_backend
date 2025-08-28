<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function index()
    {
        try {
            $feedback = Feedback::orderBy('id', 'desc')->get();

            return response()->json([
                'status' => 'success',
                'data' => $feedback,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'number' => 'required',
                'subject' => 'required',
                'feedback' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $saveData = [
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'subject' => $request->subject,
                'feedback' => $request->feedback,
            ];

            $result = Feedback::create($saveData);

            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Your feedback submitted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to submit Feedback',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
