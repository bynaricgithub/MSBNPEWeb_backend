<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Services\Masters\Master;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function fetchGallery(Request $request, Master $m)
    {
        return $m->fetchGallery($request);
    }

    public function index(Request $request, Master $m)
    {
        return $m->indexGallery($request);
    }

    public function store(Request $request, Master $m)
    {
        return $m->storeGallery($request);
    }

    public function edit(Request $request, Master $m)
    {
        return $m->editGallery($request);
    }

    public function disable(Request $request, Master $m)
    {
        return $m->disableGallery($request);
    }

    public function delete(Request $request, Master $m)
    {
        return $m->deleteGallery($request);
    }

    public function reOrdering(Request $request, Master $m)
    {
        return $m->reOrderingGallery($request);
    }
}
