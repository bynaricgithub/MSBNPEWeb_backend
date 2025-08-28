<?php

namespace App\Http\Controllers\Faq;

use App\Http\Controllers\Controller;
use App\Services\Masters\Master;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Master $m)
    {
        return $m->faqIndex();
    }

    public function indexAdmin(Master $m)
    {
        return $m->faqIndexAdmin();
    }

    public function store(Request $request, Master $m)
    {
        return $m->faqStore($request);
    }

    public function fetchFaq(Request $request, Master $m)
    {
        return $m->faqFetch($request);
    }

    public function edit(Request $request, Master $m)
    {
        return $m->faqEdit($request);
    }

    public function disable(Request $request, Master $m)
    {
        return $m->faqDisable($request);
    }

    public function delete(Request $request, Master $m)
    {
        return $m->faqDelete($request);
    }

    public function reOrder(Request $request, Master $m)
    {
        return $m->faqReOrder($request);
    }
}
