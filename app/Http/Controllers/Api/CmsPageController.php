<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;

class CmsPageController extends Controller
{
    public function cmsPage($slug)
    {
        $page = CmsPage::where('slug', $slug)
            ->where('status', 1)
            ->first();
        if (!$page) {
            return response()->json([
                    'data' => (object) [],
                    'code' => 422,
                    'status' => false,
                    'message' => 'CMS Page not found'
            ]);
        }
        return response()->json([
            'status' => true,
            'code'=>200,
            'message' => 'CMS Page found',
            'data' => $page
        ]);
    }
}
