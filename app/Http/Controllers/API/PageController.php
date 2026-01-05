<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function store(Request $request, $slug)
    {
        $detail = Pages::where('slug', $slug)->first();
        if (!$detail) {
            return '';
        }

        return $detail->contents;
    }
}
