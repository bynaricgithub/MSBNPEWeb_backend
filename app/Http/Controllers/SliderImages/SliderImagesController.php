<?php

namespace App\Http\Controllers\SliderImages;

use App\Http\Controllers\Controller;
use App\Services\Masters\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderImagesController extends Controller
{
    public function index(Request $request, Master $m)
    {
        return $m->SliderImagesIndex($request);
    }

    public function store(Request $request, Master $m)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'title' => 'required',
            // "subHeader" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        return $m->SliderImagesStore($request);
    }

    public function edit(Request $request, Master $m)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            // "image" => "required|image|mimes:png,jpg,jpeg",
            // "header" => "required",
            // "subHeader" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        return $m->SliderImagesEdit($request);
    }

    public function disable(Request $request, Master $m)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        return $m->SliderImagesDisable($request);
    }

    public function delete(Request $request, Master $m)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:home_page_slider,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        return $m->SliderImagesDelete($request);
    }

    public function reOrdering(Request $request, Master $m)
    {
        return $m->SliderImagesReOrdering($request);
    }

    public function fetchSliderImages(Request $request, Master $m)
    {
        return $m->fetchSliderImages($request);
    }
}
