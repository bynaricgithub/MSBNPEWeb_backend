<?php

namespace App\Http\Controllers\FileUploads;

use App\Http\Controllers\Controller;
use App\Services\Masters\Master;
use Illuminate\Http\Request;

class FileUploadsController extends Controller
{
    public function index(Master $m)
    {
        return $m->FileUploadsIndex();
    }

    public function indexAdmin(Master $m)
    {
        return $m->FileUploadsIndexAdmin();
    }

    public function store(Request $request, Master $m)
    {
        return $m->FileUploadsStore($request);
    }

    public function edit(Request $request, Master $m)
    {
        return $m->FileUploadsUpdate($request);
    }

    public function delete(Request $request, Master $m)
    {
        return $m->FileUploadsDelete($request);
    }

    public function disable(Request $request, Master $m)
    {

        return $m->FileUploadsDisable($request);
    }
}
