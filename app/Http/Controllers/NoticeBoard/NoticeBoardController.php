<?php

namespace App\Http\Controllers\NoticeBoard;

use App\Http\Controllers\Controller;
use App\Services\Masters\Master;
use Illuminate\Http\Request;

class NoticeBoardController extends Controller
{
    public function index(Master $m)
    {
        return $m->NoticeBoardIndex();
    }

    public function store(Request $request, Master $m)
    {
        return $m->NoticeBoardStore($request);
    }

    public function fechNoticeBoard(Request $request, Master $m)
    {
        return $m->NoticeBoardFetch($request);
    }

    public function edit(Request $request, Master $m)
    {

        return $m->NoticeBoardEdit($request);
    }

    public function disable(Request $request, Master $m)
    {

        return $m->NoticeBoardDisable($request);
    }

    public function delete(Request $request, Master $m)
    {

        return $m->NoticeBoardDelete($request);
    }

    public function reOrdering(Request $request, Master $m)
    {

        return $m->NoticeBoardReOrder($request);
    }
}
