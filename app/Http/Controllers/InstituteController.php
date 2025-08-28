<?php

namespace App\Http\Controllers;

use App\Services\Masters\Master;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function fetchInstitute(Request $request, Master $m)
    {
        return $m->fetchInstitute($request);
    }

    public function index(Request $request, Master $m)
    {
        return $m->indexInstitute($request);
    }

    public function store(Request $request, Master $m)
    {
        return $m->storeInstitute($request);
    }

    public function edit(Request $request, Master $m)
    {
        return $m->editInstitute($request);
    }

    public function disable(Request $request, Master $m)
    {
        return $m->disableInstitute($request);
    }

    public function delete(Request $request, Master $m)
    {
        return $m->deleteInstitute($request);
    }
}
