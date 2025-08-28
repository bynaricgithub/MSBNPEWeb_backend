<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\MasterCategory;
use App\Models\MasterCategoryType;
use Illuminate\Http\Request;

class MasterCategoryController extends Controller
{
    // Admin listing with optional filter
    public function indexAdmin(Request $request)
    {
        $query = MasterCategory::query()
            ->with('type')
            ->orderBy('master_category_type_id')
            ->orderBy('order_id');

        if ($request->has('master_category_type_id')) {
            $query->where('master_category_type_id', $request->master_category_type_id);
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->get(),
        ]);
    }

    // Store new category value
    public function store(Request $request)
    {
        $request->validate([
            'master_category_type_id' => 'required|exists:master_category_types,id',
            'value' => 'required|integer',
            'label' => 'required|string',
            'order_id' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        MasterCategory::create($request->only([
            'master_category_type_id',
            'value',
            'label',
            'order_id',
            'status',
        ]));

        return response()->json(['status' => 'success', 'message' => 'Sub-category created']);
    }

    // Update existing category value
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:master_categories,id',
        ]);

        $category = MasterCategory::findOrFail($request->id);

        $category->update($request->only([
            'value',
            'label',
            'order_id',
            'status',
        ]));

        return response()->json(['status' => 'success', 'message' => 'Sub-category updated']);
    }

    // Delete category
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:master_categories,id',
        ]);

        MasterCategory::findOrFail($request->id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Sub-category deleted']);
    }

    // Public API: grouped by type name
    public function groupedPublic()
    {
        $types = MasterCategoryType::with([
            'categories' => function ($q) {
                $q->where('status', 1)->orderBy('order_id');
            },
        ])->get();

        $result = [];

        foreach ($types as $type) {
            $result[$type->name] = $type->categories->map(function ($cat) use ($type) {
                return [
                    'id' => $cat->id,
                    'value' => $cat->value,
                    'label' => $cat->label,
                    'master_category_type_id' => $type->id,
                    'type_name' => $type->name,
                ];
            });
        }

        return response()->json(['status' => 'success', 'data' => $result]);
    }

    public function resolveLabel(Request $request)
    {
        $request->validate([
            'category_type_name' => 'required|exists:master_category_types,name',
            'value' => 'required|integer',
        ]);

        $type = MasterCategoryType::where('name', $request->category_type_name)->first();

        if (! $type) {
            return response()->json(['status' => 'error', 'message' => 'Category type not found'], 404);
        }

        $label = MasterCategory::where('master_category_type_id', $type->id)
            ->where('value', $request->value)
            ->value('label');

        return response()->json([
            'status' => 'success',
            'data' => [
                'label' => $label ?? null,
            ],
        ]);
    }
}
