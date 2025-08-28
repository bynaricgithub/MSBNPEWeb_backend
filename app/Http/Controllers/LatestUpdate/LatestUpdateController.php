<?php

namespace App\Http\Controllers\LatestUpdate;

use App\Http\Controllers\Controller;
use App\Services\Masters\Master;
use Illuminate\Http\Request;

class LatestUpdateController extends Controller
{
    public function index(Master $m)
    {
        return $m->LatestUpdateIndex();
    }

    public function store(Request $request, Master $m)
    {
        return $m->LatestUpdateStore($request);
    }

    public function fetchLatestUpdate(Request $request, Master $m)
    {
        return $m->fetchLatestUpdate($request);
    }

    public function edit(Request $request, Master $m)
    {

        return $m->LatestUpdateEdit($request);
    }

    public function disable(Request $request, Master $m)
    {

        return $m->LatestUpdateDisable($request);
    }

    public function delete(Request $request, Master $m)
    {

        return $m->LatestUpdateDelete($request);
    }

    public function reOrdering(Request $request, Master $m)
    {

        return $m->LatestUpdateReOrder($request);
    }
}
