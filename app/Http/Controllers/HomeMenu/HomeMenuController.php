<?php

namespace App\Http\Controllers\HomeMenu;

use App\Http\Controllers\Controller;
use App\Models\HomeMenu;
use App\Models\User_Tracker;
use App\Services\Masters\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Master $m)
    {
        return $m->indexHomeMenu($request);
    }

    // -------------------------Reorder APIs start-----------------------------
    public function reorderUp(Request $request, Master $m)
    {
        return $m->reorderUp($request);
    }

    public function sortTable(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'data' => 'required|array',
                'sortingTable' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }
            $i = 1;
            $sortingTable = $request->sortingTable;
            foreach ($request->data as $item) {
                DB::table($sortingTable)->where('id', $item['id'])->update(['order_id' => $i]);
                $i += 1;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Order updated',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function reorderDown(Request $request, Master $m)
    {
        return $m->reorderDown($request);
    }

    public function reorderMenu(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'data' => 'required|array',
                // 'parent_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }
            $i = 1;
            foreach ($request->data as $item) {
                HomeMenu::where('id', $item['id'])->update(['order_id' => $i]);
                $i += 1;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Order updated',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // -------------------------Reorder APIs end--------------------------------

    public function saveVisitorCount(Request $request)
    {
        $ip = $request->ip();
        $res = User_Tracker::select('id', 'ip', 'count')->where('ip', $ip)->first();
        if ($res && $res->id) {
            $res->count = $res->count + 1;
            $res->save();
        } else {
            User_Tracker::create(['ip' => $ip, 'count' => 1]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Counter Save Successfully',
        ], 200);
    }

    public function getUserVisitCount(Request $request, Master $m)
    {
        return $m->getUserVisitCount($request);
    }

    public function getLastUpdateDate(Request $request, Master $m)
    {
        return $m->getLastUpdateDate($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Master $m)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'menu_url' => '',
            // 'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        return $m->storeHomeMenu($input);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Master $m)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'id' => 'required',

            'title' => 'required',
            'parent_id' => 'required',
            'menu_url' => 'required',
            // 'order_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        return $m->updateHomeMenu($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Master $m)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:homemenu,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        return $m->destroyHomeMenu($request);
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

        return $m->disable($request);
    }

    public function fetchHomeMenu(Request $request, Master $m)
    {
        return $m->fetchHomeMenu($request);
    }
}
