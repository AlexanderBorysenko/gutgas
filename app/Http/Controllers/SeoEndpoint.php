<?php

namespace App\Http\Controllers;

use App\Models\SeoEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SeoEndpoint extends Controller
{
    public function __invoke(Request $request, $locale, $route = '', $pageNumber = null)
    {
        $isHomePage = $route === '' || preg_match('/^page-[0-9]+$/', $route);
        $pageNumber = $isHomePage ?
            (int) preg_replace('/^page-/', '', $route)
            : $pageNumber;

        if (
            $isHomePage
        ) {
            $seoEntity = SeoEntity::where('slug', 'LIKE', '/')->firstOrFail();
        } else {
            $seoEntity = SeoEntity::where('slug', 'LIKE', $route)->firstOrFail();
        }
        if (!$seoEntity || !$seoEntity->is_active) {
            abort(404);
        }

        $seoEntiteable = $seoEntity->seoEntiteable;

        if (!$seoEntiteable) {
            abort(404);
        }

        if ($pageNumber) {
            $request->merge(['pageNumber' => $pageNumber]);
        }

        return App::make($seoEntity->controller)->callAction($seoEntity->action, [
            $request,
            $seoEntiteable
        ]);
    }
}
