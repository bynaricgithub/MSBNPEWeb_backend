<?php

namespace App\Http\Controllers\Circular;

use App\Http\Controllers\Controller;
use App\Services\Masters\Master;
use Illuminate\Http\Request;

class CircularController extends Controller
{
    public function index(Master $m)
    {
        return $m->CircularIndex();
    }

    public function indexAdmin(Master $m)
    {
        return $m->CircularIndexAdmin();
    }

    public function store(Request $request, Master $m)
    {
        return $m->CircularStore($request);
    }

    public function edit(Request $request, Master $m)
    {
        return $m->CircularUpdate($request);
    }

    public function delete(Request $request, Master $m)
    {
        return $m->CircularDelete($request);
    }

    public function disable(Request $request, Master $m)
    {

        return $m->CircularDisable($request);
    }
}
