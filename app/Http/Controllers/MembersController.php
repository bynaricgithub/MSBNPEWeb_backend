<?php

namespace App\Http\Controllers;

use App\Services\Masters\Master;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function fetchMembers(Request $request, Master $m)
    {
        return $m->fetchMembers($request);
    }

    public function index(Request $request, Master $m)
    {
        return $m->indexMembers($request);
    }

    public function indexByType($type, Master $m)
    {
        return $m->membesType($type);
    }

    public function store(Request $request, Master $m)
    {
        return $m->storeMembers($request);
    }

    public function edit(Request $request, Master $m)
    {
        return $m->editMembers($request);
    }

    public function disable(Request $request, Master $m)
    {
        return $m->disableMembers($request);
    }

    public function delete(Request $request, Master $m)
    {
        return $m->deleteMembers($request);
    }
}
