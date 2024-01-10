<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageInfoController extends Controller
{
    public function getPageInfo(Request $request)
    {
        $pageInfo = [
            'url' => $request->url(),
            'method' => $request->method(),
        ];

        return response()->json($pageInfo);
    }
}
