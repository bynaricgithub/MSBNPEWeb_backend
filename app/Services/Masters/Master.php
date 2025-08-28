<?php

namespace App\Services\Masters;

use App\Models\Circular;
use App\Models\Faq;
use App\Models\FileUploads;
use App\Models\Gallery;
use App\Models\HomeMenu;
use App\Models\Institute;
use App\Models\LatestUpdate;
use App\Models\Members;
use App\Models\NoticeBoard;
use App\Models\Program;
use App\Models\SliderImages;
use App\Models\TableContent;
use App\Models\User_Tracker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Master
{
    // ?----------------------------VisitorCount-start--------------------------------------------------------------

    public function getUserVisitCount()
    {
        try {
            $res = User_Tracker::count();

            return response()->json([
                'status' => 'success',
                'message' => 'Visitor Count fetched successfully',
                'data' => $res,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
                'data' => '',
            ], 500);
        }
    }

    public function getLastUpdateDate()
    {
        try {
            $result = DB::select(
                "SELECT MAX(maxDate) as 'lastUpdatedDate' FROM 
                ( 
                    SELECT MAX(updated_at) as 'maxDate' FROM homemenu
                    UNION SELECT MAX(updated_at) as 'maxDate' FROM circulars
                    UNION SELECT MAX(updated_at) as 'maxDate' FROM home_page_slider
                    UNION SELECT MAX(updated_at) as 'maxDate' FROM latest_update
                    UNION SELECT MAX(updated_at) as 'maxDate' FROM news_and_events
                    -- UNION SELECT MAX(updated_at) as 'maxDate' FROM acts 
                    -- UNION SELECT MAX(updated_at) as 'maxDate' FROM annual_reports 
                    -- UNION SELECT MAX(updated_at) as 'maxDate' FROM corrigedums
                    -- UNION SELECT MAX(updated_at) as 'maxDate' FROM curriculums
                    -- UNION SELECT MAX(updated_at) as 'maxDate' FROM g_r_s
                    -- UNION SELECT MAX(updated_at) as 'maxDate' FROM norms
                    UNION SELECT MAX(updated_at) as 'maxDate' FROM notice_boards
                    UNION SELECT MAX(updated_at) as 'maxDate' FROM p_d_f_s
                ) my_tab;"
            );
            if ($result) {
                $date = $result[0]->lastUpdatedDate ? Carbon::createFromFormat('Y-m-d H:i:s', $result[0]->lastUpdatedDate, env('APP_TIMEZONE'))->getPreciseTimestamp(3) : '';

                return response()->json([
                    'status' => 'success',
                    'message' => 'Last updated date fetched successfully',
                    'data' => $date,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Latest Updates...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    // ?----------------------------VisitorCount-end----------------------------------------------------------------
    // ?----------------------------HomeMenu-start--------------------------------------------------------------
    public function indexHomeMenu($request)
    {
        try {
            $result = HomeMenu::get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'msg' => 'Menus list fetched successfully.',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Homemenu...Error:' . $e->getMessage(),
            ], 500);
        }
    }

    public function storeHomeMenu($input)
    {
        try {
            $saveData = [
                'title' => $input['title'],
                'menu_url' => $input['menu_url'],
            ];
            if ($input['parent_id']) {
                $saveData['parent_id'] = $input['parent_id'];
            }
            $result = Homemenu::create($saveData);
            $id = $result->id;
            if (empty($input['parent_id'])) {
                $res = HomeMenu::whereColumn('id', 'parent_id')->get();
                Homemenu::where('id', $id)->update([
                    'parent_id' => $id,
                    'order_id' => count($res) + 1,
                ]);
            } else {
                $res = HomeMenu::where('parent_id', $input['parent_id'])->get();
                Homemenu::where('id', $id)->update([
                    'order_id' => count($res) + 1,
                ]);
            }

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Homemenu added successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to add homemenu',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateHomeMenu($request)
    {
        try {
            $result = DB::table('homemenu')->where('id', $request['id'])->limit(1)->update([
                'title' => $request['title'],
                'parent_id' => $request['parent_id'],
                'menu_url' => $request['menu_url'],
            ]);
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Homemenu updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to edit homemenu because of no change in data',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroyHomeMenu($request)
    {
        try {
            $result = Homemenu::where('id', $request->id)->delete();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Homemenu deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to delete Homemenu',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function disable($request)
    {
        try {

            $result = Homemenu::where('id', $request->id)->update(['status' => $request->status]);
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => $request->id == 1 ? 'Status enabled successfully' : 'Status disabled successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function fetchHomeMenu($request)
    {
        try {
            $result = Homemenu::where('status', 1)->get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'msg' => 'Menus list fetched successfully.',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Homemenu...Error:' . $e->getMessage(),
            ], 400);
        }
    }
    // ?----------------------------HomeMenu-end--------------------------------------------------------------

    // ?----------------------------latestUpdate-start--------------------------------------------------------------

    public function LatestUpdateIndex()
    {
        try {
            $result = LatestUpdate::get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Latest Update list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Latest update...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function fetchLatestUpdate()
    {
        try {
            $result = LatestUpdate::where('status', 1)->get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Latest Update list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Latest update...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function LatestUpdateStore($request)
    {
        try {
            $lastId = LatestUpdate::orderBy('id', 'desc')->first();
            $latestUpdate = [
                'title' => $request->title,
                'order_id' => $lastId ? ($lastId->id) + 1 : 1,
                'link' => $request->link,
            ];
            // if ($request->hasFile('link')) {
            //     $file = $request->file('link');
            //     $title = Str::slug($request->title);
            //     $filename1 = uploadFile($file, $title, null, 'latestUpdateUpload');
            //     // $filename = Config::get('constants.PROJURL') . '/' . $filename1;
            //     $filename = $filename1;
            //     $latestUpdate['link'] = $filename;
            // }
            $result = LatestUpdate::create($latestUpdate);
            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Latest update record added successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to add latest update record',
                ], 400);
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function LatestUpdateEdit($request)
    {
        try {
            $latestUpdate = [
                'title' => $request->title,
                // 'link' => $request->link,
            ];
            if ($request->link) {
                $latestUpdate['link'] = $request->link;
            }
            $id = $request->id;
            // if ($request->hasFile('link')) {
            //     $file = $request->file('link');
            //     $title = Str::slug($request->title);
            //     $filename1 = uploadFile($file, $title, null, 'latestUpdateUpload');
            //     // $filename = Config::get('constants.PROJURL') . '/' . $filename1;
            //     $filename = $filename1;

            //     $latestUpdate['link'] = $filename;
            // }
            $result = LatestUpdate::where('id', $id)->update($latestUpdate);

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Latest Update record updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to edit Latest Update record',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function LatestUpdateDisable($request)
    {
        try {

            $result = LatestUpdate::where('id', $request->id)->update(['status' => $request->status]);
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => $request->status == 1 ? 'Status enabled successfully' : 'Status disabled successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function LatestUpdateDelete($request)
    {
        try {
            $result = LatestUpdate::where('id', $request->id)->delete();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Latest update record deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to delete latest update record',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function LatestUpdateReOrdering($request)
    {
        try {

            // $result = LatestUpdateModel::where('id', $request->id)->delete();
            // if ($result) {
            //     return response()->json([
            //         'status'     => 'success',
            //         'message' => 'Homemenu deleted successfully',
            //     ], 200);
            // } else {
            //     return response()->json([
            //         'status'     => 'failure',
            //         'message' => 'Failed to delete Homemenu',
            //     ], 400);
            // }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ?----------------------------latestUpdate-end--------------------------------------------------------------

    // ?------------------------SliderImages-start----------------------------------------------------

    public function SliderImagesIndex()
    {
        try {
            $result = SliderImages::get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Slider image list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Homemenu...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function fetchSliderImages()
    {
        try {
            $result = SliderImages::where('status', 1)->get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Slider image list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching slider image...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function SliderImagesStore($request)
    {
        try {
            $lastId = SliderImages::orderBy('id', 'desc')->first();
            $sliderImage = [
                'title' => $request->title,
                'image' => $request->image,
                // 'subHeader' => $request->subHeader,
                'order_id' => $lastId ? ($lastId->id) + 1 : 1,
                'alternate_name' => ($lastId ? ($lastId->id) + 1 : 1) . '-slider',
            ];
            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $lastId = $lastId ? $lastId->id + 1 : 1;
            //     $filename1 = uploadFile($file, $lastId.'-slider', null, 'sliderImageUpload');
            //     // $filename = Config::get('constants.PROJURL') . '/' . $filename1;
            //     $filename = $filename1;

            //     $sliderImage['image'] = $filename;
            //     $sliderImage['alternate_name'] = $lastId.'-slider';
            // }
            $result = SliderImages::create($sliderImage);
            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Slider image added successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to add slider image',
                ], 400);
            }
        } catch (\Exception $e) {
            // checkExitsFile($filename1);
            DB::rollback();

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function SliderImagesEdit($request)
    {
        try {
            $sliderImage = [];
            if ($request->title) {
                $sliderImage['title'] = $request->title;
            }
            if ($request->image) {
                $sliderImage['image'] = $request->image;
            }
            $id = $request->id;
            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $filename = uploadFile($file, $id.'-slider', null, 'sliderImageUpload');
            //     // $filename = Config::get('constants.PROJURL') . '/' . $filename;
            //     $filename = $filename;

            //     $sliderImage['image'] = $filename;
            //     $sliderImage['alternate_name'] = $id.'-slider';
            // }
            $result = SliderImages::where('id', $id)->update($sliderImage);

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Slider Image updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to edit Slider Image',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function SliderImagesDisable($request)
    {
        try {

            $result = SliderImages::where('id', $request->id)->update(['status' => $request->status]);
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => $request->status == 1 ? 'Status enabled successfully' : 'Status disabled successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function SliderImagesDelete($request)
    {
        try {

            $result = SliderImages::where('id', $request->id)->delete();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Slider image deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to delete Slider image',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function SliderImagesReOrdering($request)
    {
        try {

            // $result = SliderImagesModel::where('id', $request->id)->delete();
            // if ($result) {
            //     return response()->json([
            //         'status'     => 'success',
            //         'message' => 'Homemenu deleted successfully',
            //     ], 200);
            // } else {
            //     return response()->json([
            //         'status'     => 'failure',
            //         'message' => 'Failed to delete Homemenu',
            //     ], 400);
            // }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ?------------------------SliderImages-end----------------------------------------------------

    public function reorderUp($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'parent_id' => 'required',
            // 'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        if ($request->order_id) {
            $updateData = ['order_id' => $request->order_id - 1];
        } else {
            $updateData = ['order_id' => 1];
        }
        // $result = HomeMenu::where('parent_id', $request->parent_id)->get();

        // foreach ($result as $item) {
        //     if ($item->order_id == $request->order_id - 1) {
        //         $res = HomeMenu::where('id', $item->id)->first();
        //         HomeMenu::where('id', $res->id)->update(['order_id' => $res->order_id + 1]);
        //     }
        // }
        HomeMenu::where('id', $request->id)->update($updateData);

        return response()->json([
            'status' => 'success',
            'message' => 'Moved Up',
        ], 200);
    }

    public function reorderDown($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'parent_id' => 'required',
            // 'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        if ($request->order_id) {
            $updateData = ['order_id' => $request->order_id + 1];
        } else {
            $updateData = ['order_id' => 1];
        }
        // $result = HomeMenu::where('parent_id', $request->parent_id)->get();
        // foreach ($result as $item) {
        //     if ($item->order_id == $request->order_id + 1) {
        //         $res = HomeMenu::where('id', $item->id)->first();
        //         HomeMenu::where('id', $res->id)->update(['order_id' => $res->order_id - 1]);
        //     }
        // }
        HomeMenu::where('id', $request->id)->update($updateData);

        return response()->json([
            'status' => 'success',
            'message' => 'Moved Down',
        ], 200);
    }

    // ?----------------------------Notic Board-start--------------------------------------------------------------
    public function NoticeBoardIndex()
    {
        try {
            $result = NoticeBoard::get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Notice board record list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching notice board record...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function NoticeBoardFetch($request)
    {
        try {
            $result = NoticeBoard::where('status', 1)->get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Notice board record list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching notice board record...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function NoticeBoardStore($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'link' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $lastId = NoticeBoard::orderBy('id', 'desc')->first();
            $noticeBoard = [
                'title' => $request->title,
                'order_id' => $lastId ? ($lastId->id) + 1 : 1,
                'link' => $request->link,
            ];
            // if ($request->hasFile('link')) {
            //     $file = $request->file('link');
            //     $filename1 = uploadFile($file, ($lastId ? ($lastId->id) + 1 : 1).'-noticeBoard', null, 'noticeBoardUpload');
            //     // $filename = Config::get('constants.PROJURL') . '/' . $filename1;
            //     $filename = $filename1;

            //     $noticeBoard['link'] = $filename;
            // } else {
            //     $noticeBoard['link'] = $request->link;
            // }
            $result = NoticeBoard::create($noticeBoard);
            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Notice board record added successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to add notice board record',
                ], 400);
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function NoticeBoardEdit($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $noticeBoard = [
                'title' => $request->title,
                // 'link' => $request->link,
            ];
            if ($request->link) {
                $noticeBoard['link'] = $request->link;
            }
            $id = $request->id;
            // if ($request->hasFile('link')) {
            //     $lastId = NoticeBoard::where('id', $id)->first();
            //     $file = $request->file('link');
            //     $filename1 = uploadFile($file, ($lastId ? $lastId->id : 1).'-noticeBoard', null, 'noticeBoardUpload');
            //     // $filename = Config::get('constants.PROJURL') . '/' . $filename1;
            //     $filename = $filename1;

            //     $noticeBoard['link'] = $filename;
            // } else {
            //     $noticeBoard['link'] = $request->link;
            // }
            $result = NoticeBoard::where('id', $id)->update($noticeBoard);

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Notice board record updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to edit notice board record',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function NoticeBoardDisable($request)
    {
        try {
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
            $result = NoticeBoard::where('id', $request->id)->update(['status' => $request->status]);
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => $request->status == 1 ? 'Status enabled successfully' : 'Status disabled successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function NoticeBoardDelete($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $result = NoticeBoard::where('id', $request->id)->delete();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Notice Board record deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to delete notice Board record',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function NoticeBoardReOrder($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:news_and_events,id',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }
            // $result = NoticeBoardModel::where('id', $request->id)->delete();
            // if ($result) {
            //     return response()->json([
            //         'status'     => 'success',
            //         'message' => 'Homemenu deleted successfully',
            //     ], 200);
            // } else {
            //     return response()->json([
            //         'status'     => 'failure',
            //         'message' => 'Failed to delete Homemenu',
            //     ], 400);
            // }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ?----------------------------Notic Board-End--------------------------------------------------------------

    // ?----------------------------News and events / Gallery -start --------------------------------------------

    public function fetchGallery($request)
    {
        try {
            $result = Gallery::where('status', 1)->get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'News and events list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching news and events...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function indexGallery($request)
    {
        try {
            $result = Gallery::get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'News and events list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching news and events...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function storeGallery($request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $lastId = Gallery::orderBy('id', 'desc')->first();
            $Gallerys = [
                'title' => $request->title,
                'order_id' => $lastId ? ($lastId->id) + 1 : 1,
                'image' => $request->image,
                'category' => $request->category,
            ];
            $result = Gallery::create($Gallerys);
            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'News and event record added successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to add news and event record',
                ], 400);
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function editGallery($request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $Gallerys = [
                'title' => $request->title,
            ];
            if ($request->image) {
                $Gallerys['image'] = $request->image;
            }
            $id = $request->id;

            $result = Gallery::where('id', $id)->update($Gallerys);

            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'News and event record updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to edit news and event record',
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function disableGallery($request)
    {
        try {
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
            $result = Gallery::where('id', $request->id)->update(['status' => $request->status]);
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => $request->status == 1 ? 'Status enabled successfully' : 'Status disabled successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function deleteGallery($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:gallery,id',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $result = Gallery::where('id', $request->id)->delete();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'News and event record deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to delete news and event record',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function reOrderingGallery($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:gallery,id',

            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }
            // $result = Gallery::where('id', $request->id)->delete();
            // if ($result) {
            //     return response()->json([
            //         'status'     => 'success',
            //         'message' => 'Homemenu deleted successfully',
            //     ], 200);
            // } else {
            //     return response()->json([
            //         'status'     => 'failure',
            //         'message' => 'Failed to delete Homemenu',
            //     ], 400);
            // }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ?----------------------------News and events / Gallery -end ---------------------------------------------

    // ?----------------------------Circular-start--------------------------------------------------------------

    public function CircularIndex()
    {
        try {
            $result = Circular::where('status', 1)->get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Circular list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Circular ..Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function CircularIndexAdmin()
    {
        try {
            $result = Circular::get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Circular list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Circular ..Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function CircularStore($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required',
                'title' => 'required',
                'link' => 'required',
                'type' => 'required',

                'dept' => 'required_if:type,1',
                'last_date' => 'required_if:type,2',
                'inst' => 'required_if:type,1,required_if:type,2',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }
            $lastId = Circular::orderBy('id', 'desc')->first();
            $circularData = [
                'date' => $request->date,
                'title' => $request->title,

                'inst' => $request->inst,
                'order_id' => $lastId ? ($lastId->id) + 1 : 1,
                'link' => $request->link,
                'type' => $request->type,
            ];

            if ($request->type == 1) {
                $circularData['dept'] = $request->dept;
            }
            if ($request->type == 2) {
                $circularData['last_date'] = $request->last_date;
            }

            DB::beginTransaction();

            $result = Circular::create($circularData);
            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Circular record added successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to add Circular record',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function CircularUpdate($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'type' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $circular = [
                'title' => $request->title,
                'inst' => $request->inst,
                'type' => $request->type,
                'date' => $request->date,

                'dept' => $request->dept,
                'last_date' => $request->last_date,
            ];
            if ($request->link) {
                $circular['link'] = $request->link;
            }

            $id = $request->id;

            $result = Circular::where('id', $id)->update($circular);

            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Circular record updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to edit Circular record',
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function CircularDelete($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $result = Circular::where('id', $request->id)->delete();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Circular record deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to delete Circular record',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function Circulardisable($request)
    {
        try {
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
            $result = Circular::where('id', $request->id)->update(['status' => $request->status]);
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => $request->status == 1 ? 'Status enabled successfully' : 'Status disabled successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // ?----------------------------Circular-end--------------------------------------------------------------

    // ?----------------------------File Uploads-start--------------------------------------------------------------

    public function FileUploadsIndex()
    {
        try {
            $result = FileUploads::where('status', 1)->get();

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'FileUploads list fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function FileUploadsIndexAdmin()
    {
        try {
            $result = FileUploads::get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'FileUploads list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching FileUploads ..Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function FileUploadsStore($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
                'title' => 'required|string|max:255',
                'link' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            DB::beginTransaction();

            FileUploads::create([
                'date' => $request->date,
                'title' => $request->title,
                'link' => $request->link,
                'status' => 1,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'FileUploads record added successfully',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function FileUploadsUpdate($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:file_uploads,id',
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'link' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            DB::beginTransaction();

            $data = $request->only(['title', 'date']);
            if ($request->has('link')) {
                $data['link'] = $request->link;
            }

            FileUploads::where('id', $request->id)->update($data);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'FileUploads record updated successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function FileUploadsDelete($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:file_uploads,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            FileUploads::where('id', $request->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'FileUploads record deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function FileUploadsDisable($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:file_uploads,id',
                'status' => 'required|in:0,1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            FileUploads::where('id', $request->id)->update(['status' => $request->status]);

            return response()->json([
                'status' => 'success',
                'message' => $request->status ? 'Enabled successfully' : 'Disabled successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ?----------------------------File Uploads-end--------------------------------------------------------------

    // ?----------------------------Page-content-start--------------------------------------------------------

    public function fetchPageContent()
    {
        try {
            $result = TableContent::where('status', 1)->orderBy('order_id')->get();

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'Page content fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function PageContentIndexAdmin()
    {
        try {
            $result = TableContent::get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Page Content list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching FileUploads ..Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function PageContentIndexByType($type)
    {
        try {
            $result = TableContent::where('status', 1)->where('type', $type)->orderBy('order_id')->get();

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'Content by type fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function PageContentStore($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
                'title' => 'required|string',
                'type' => 'required|integer',
                'downloads' => 'nullable|array',
                'downloads.*.title' => 'required_with:downloads|string',
                'downloads.*.link' => 'required_with:downloads|string',
                'links' => 'nullable|array',
                'links.*.title' => 'required_with:links|string',
                'links.*.link' => 'required_with:links|string',
                'note' => 'nullable|string',
                'imageUrl' => 'nullable|string',
                'mainUrl' => 'nullable|string',
                'description' => 'nullable|string',
                // 'last_date' => 'nullable|date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            DB::beginTransaction();

            $order_id = TableContent::max('order_id') + 1;

            $data = [
                'title' => $request->title,
                'date' => $request->date,
                'type' => $request->type,
                // 'last_date' => $request->last_date,
                'note' => $request->note,
                'imageUrl' => $request->imageUrl,
                'mainUrl' => $request->mainUrl,
                'description' => $request->description,
                'order_id' => $order_id,
                'status' => 1,
            ];

            if ($request->has('downloads')) {
                $data['downloads'] = json_encode($request->downloads);
            }

            if ($request->has('links')) {
                $data['links'] = json_encode($request->links);
            }

            TableContent::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Page content created successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function PageContentUpdate($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'title' => 'required|string',
                'type' => 'required|integer',
                'date' => 'required|date',
                // 'last_date' => 'nullable|date',
                'downloads' => 'nullable|array',
                'downloads.*.title' => 'required_with:downloads|string',
                'downloads.*.link' => 'required_with:downloads|string',
                'links' => 'nullable|array',
                'links.*.title' => 'required_with:links|string',
                'links.*.link' => 'required_with:links|string',
                'note' => 'nullable|string',
                'imageUrl' => 'nullable|string',
                'mainUrl' => 'nullable|string',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            DB::beginTransaction();

            $data = [
                'title' => $request->title,
                'date' => $request->date,
                'type' => $request->type,
                // 'last_date' => $request->last_date,
                'note' => $request->note,
                'imageUrl' => $request->imageUrl,
                'mainUrl' => $request->mainUrl,
                'description' => $request->description,
            ];

            if ($request->has('downloads')) {
                $data['downloads'] = json_encode($request->downloads);
            }

            if ($request->has('links')) {
                $data['links'] = json_encode($request->links);
            }

            TableContent::where('id', $request->id)->update($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Page content updated successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function PageContentDelete($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            TableContent::where('id', $request->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Page content deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function PageContentDisable($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'status' => 'required|in:0,1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            TableContent::where('id', $request->id)->update([
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => $request->status == 1 ? 'Enabled successfully' : 'Disabled successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ?----------------------------Page-content-end----------------------------------------------------------

    // ?----------------------------Members-start--------------------------------------------------------------

    public function fetchMembers($request)
    {
        try {
            $result = Members::where('status', 1)->latest()->get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Members list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Members...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function indexMembers($request)
    {
        try {
            $result = Members::get();
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                    'message' => 'Members list fetched successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Problem Fetching Members...Error:' . $e->getMessage(),
            ], 400);
        }
    }

    public function membesType($type)
    {
        try {
            $result = Members::where('status', 1)->where('type', $type)->orderBy('order_id')->get();

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'Content by type fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function storeMembers($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'required',
                // 'link' => 'required',
                // "type" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $lastId = Members::orderBy('id', 'desc')->first();
            $Members = [
                'title' => $request->title,
                'order_id' => $lastId ? ($lastId->id) + 1 : 1,
                'link' => $request->link,
                'image' => $request->image,
            ];

            $Members['subtitle'] = $request->subtitle;

            $result = Members::create($Members);

            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Member record added successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to add Members record',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function editMembers($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                // "type" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $Members = [
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                // "type" => $request->type,
            ];
            if ($request->image) {
                $Members['image'] = $request->image;
            }
            // if ($request->link) {
            //     $Members['link'] = $request->link;
            // }

            $id = $request->id;

            $result = Members::where('id', $id)->update($Members);

            if ($result) {
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Members record updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to Members and event record',
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function disableMembers($request)
    {
        try {
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
            $result = Members::where('id', $request->id)->update(['status' => $request->status]);
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => $request->status == 1 ? 'Status enabled successfully' : 'Status disabled successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function deleteMembers($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $result = Members::where('id', $request->id)->delete();

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Members record deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Failed to delete Members record',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ?----------------------------Members-end----------------------------------------------------------------

    // ?----------------------------Institute-start-------------------------------------------------------------

    public function fetchInstitute()
    {
        try {
            $result = Institute::where('status', 1)
                ->orderBy('id')
                ->get(['id', 'inst_code', 'inst_name']);

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'Institute list fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function indexInstitute()
    {
        try {
            $result = Institute::orderBy('id')->get();

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'All Institute fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function storeInstitute($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'inst_code' => 'required|string|unique:institutes,inst_code',
                'inst_name' => 'required|string',
                'category' => 'required|string',
                'duration' => 'required|string',
                'examination' => 'required|string',
                'registration' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $Institute = [
                'inst_code' => $request->inst_code,
                'inst_name' => $request->inst_name,
                'category' => $request->category,
                'duration' => $request->duration,
                'examination' => $request->examination,
                'registration' => $request->registration,
                'status' => 1,
            ];

            Institute::create($Institute);

            return response()->json([
                'status' => 'success',
                'message' => 'Institute added successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function editInstitute($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:institutes,id',
                'inst_code' => 'required|string',
                'inst_name' => 'required|string',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $updateData = $request->only(['inst_code', 'inst_name']);
            Institute::where('id', $request->id)->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Institute updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function disableInstitute($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:institutes,id',
                'status' => 'required|in:0,1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            Institute::where('id', $request->id)->update(['status' => $request->status]);

            return response()->json([
                'status' => 'success',
                'message' => $request->status == 1 ? 'Institute enabled successfully' : 'Institute disabled successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteInstitute($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:institutes,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            Institute::where('id', $request->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Institute deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // -------------------------Institute Ends -------------------------------------------------------


    // ?----------------------------Programs-start-------------------------------------------------------------

    public function fetchPrograms()
    {
        try {
            $result = Program::where('status', 1)
                ->orderByDesc('id')
                ->get(['id', 'category', 'duration', 'examination', 'registration']);

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'Program list fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function indexPrograms()
    {
        try {
            $result = Program::orderByDesc('id')->get();

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'All programs fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function storePrograms($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category' => 'required|string',
                'duration' => 'required|string',
                'examination' => 'required|string',
                'registration' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $lastId = Program::max('id');
            $program = [
                'category' => $request->category,
                'duration' => $request->duration,
                'examination' => $request->examination,
                'registration' => $request->registration,
                'status' => 1,
            ];

            Program::create($program);

            return response()->json([
                'status' => 'success',
                'message' => 'Program added successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function editPrograms($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:programs,id',
                'category' => 'required|string',
                'duration' => 'required|string',
                'examination' => 'required|string',
                'registration' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $updateData = $request->only(['category', 'duration', 'examination', 'registration']);
            Program::where('id', $request->id)->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Program updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function disablePrograms($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:programs,id',
                'status' => 'required|in:0,1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            Program::where('id', $request->id)->update(['status' => $request->status]);

            return response()->json([
                'status' => 'success',
                'message' => $request->status == 1 ? 'Program enabled successfully' : 'Program disabled successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deletePrograms($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:programs,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            Program::where('id', $request->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Program deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // -------------------------Program Ends -------------------------------------------------------

    // ---------------------------FAQ Starts -------------------------------------------------------

    public function faqIndex()
    {
        try {
            $result = Faq::with('category')->get();

            return response()->json(['status' => 'success', 'data' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failure', 'message' => 'Error: ' . $e->getMessage()], 400);
        }
    }

    public function faqIndexAdmin()
    {
        $data = Faq::with('category') // assuming category relationship exists
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'faq_category_id' => $item->faq_category_id,
                    'category_label' => $item->category->label ?? '',
                    'question' => $item->question,
                    'answer' => $item->answer,
                    'status' => $item->status,
                ];
            });

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function faqFetch($request)
    {
        try {
            $query = Faq::with('category')->where('status', 1);

            if ($request->has('category')) {
                $query->where('faq_category_id', $request->category);
            }

            $result = $query->orderBy('order_id')->get();

            return response()->json(['status' => 'success', 'data' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failure', 'message' => 'Error: ' . $e->getMessage()], 400);
        }
    }

    public function faqStore($request)
    {
        DB::beginTransaction();
        try {
            $lastOrder = Faq::max('order_id');

            $faq = [
                'faq_category_id' => $request->faq_category_id,
                'question' => $request->question,
                'answer' => $request->answer,
                'order_id' => $lastOrder ? $lastOrder + 1 : 1,
                'status' => 1,
            ];

            Faq::create($faq);
            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'FAQ created successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['status' => 'failure', 'message' => $e->getMessage()], 500);
        }
    }

    public function faqEdit($request)
    {
        try {
            $faq = [
                'faq_category_id' => $request->faq_category_id,
                'question' => $request->question,
                'answer' => $request->answer,
            ];

            $result = Faq::where('id', $request->id)->update($faq);

            return response()->json([
                'status' => $result ? 'success' : 'failure',
                'message' => $result ? 'FAQ updated successfully' : 'Failed to update FAQ',
            ], $result ? 200 : 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failure', 'message' => $e->getMessage()], 500);
        }
    }

    public function faqDisable($request)
    {
        try {
            $result = Faq::where('id', $request->id)->update(['status' => $request->status]);

            return response()->json([
                'status' => 'success',
                'message' => $request->status == 1 ? 'FAQ enabled successfully' : 'FAQ disabled successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failure', 'message' => $e->getMessage()], 400);
        }
    }

    public function faqDelete($request)
    {
        try {
            $result = Faq::where('id', $request->id)->delete();

            return response()->json([
                'status' => $result ? 'success' : 'failure',
                'message' => $result ? 'FAQ deleted successfully' : 'Failed to delete FAQ',
            ], $result ? 200 : 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failure', 'message' => $e->getMessage()], 500);
        }
    }

    public function faqReOrder($request)
    {
        try {
            foreach ($request->reorderedFaqs as $item) {
                Faq::where('id', $item['id'])->update(['order_id' => $item['order_id']]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'FAQ order updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failure', 'message' => $e->getMessage()], 500);
        }
    }

    // ---------------------------FAQ Ends-- -------------------------------------------------------
}
