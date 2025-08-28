<?php

namespace App\Http\Controllers\PageContent;

use App\Http\Controllers\Controller;
use App\Services\Masters\Master;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    public function fetchPageContent(Master $m)
    {
        return $m->fetchPageContent();
    }

    public function indexByType($type, Master $m)
    {
        return $m->PageContentIndexByType($type);
    }

    public function indexAdmin(Master $m)
    {
        return $m->PageContentIndexAdmin();
    }

    public function store(Request $request, Master $m)
    {
        return $m->PageContentStore($request);
    }

    public function edit(Request $request, Master $m)
    {
        return $m->PageContentUpdate($request);
    }

    public function delete(Request $request, Master $m)
    {
        return $m->PageContentDelete($request);
    }

    public function disable(Request $request, Master $m)
    {
        return $m->PageContentDisable($request);
    }
}
