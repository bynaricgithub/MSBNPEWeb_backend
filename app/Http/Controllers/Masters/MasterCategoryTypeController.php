<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\MasterCategoryType;
use Illuminate\Http\Request;

class MasterCategoryTypeController extends Controller
{
    public function index()
    {
        $data = MasterCategoryType::orderBy('id')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:master_category_types,name',
            'label' => 'required|string',
        ]);

        MasterCategoryType::create($request->only(['name', 'label']));

        return response()->json(['status' => 'success', 'message' => 'Category type created']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:master_category_types,id',
        ]);

        $categoryType = MasterCategoryType::findOrFail($request->id);
        $categoryType->update($request->only(['name', 'label']));

        return response()->json(['status' => 'success', 'message' => 'Category type updated']);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:master_category_types,id',
        ]);

        MasterCategoryType::findOrFail($request->id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Category type deleted']);
    }
}
