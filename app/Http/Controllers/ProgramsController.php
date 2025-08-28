<?php

namespace App\Http\Controllers;

use App\Services\Masters\Master;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    public function fetchPrograms(Request $request, Master $m)
    {
        return $m->fetchPrograms($request);
    }

    public function index(Request $request, Master $m)
    {
        return $m->indexPrograms($request);
    }

    public function store(Request $request, Master $m)
    {
        return $m->storePrograms($request);
    }

    public function edit(Request $request, Master $m)
    {
        return $m->editPrograms($request);
    }

    public function disable(Request $request, Master $m)
    {
        return $m->disablePrograms($request);
    }

    public function delete(Request $request, Master $m)
    {
        return $m->deletePrograms($request);
    }
}
