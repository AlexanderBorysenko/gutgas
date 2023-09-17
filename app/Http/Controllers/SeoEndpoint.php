<?php

namespace App\Http\Controllers;

use App\Models\SeoEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SeoEndpoint extends Controller
{
    public function __invoke(Request $request, $locale, $route = '')
    {
        $route = ltrim(str_replace($locale, '', $route), '/');

        if ($route === '') {
            $seoEntity = SeoEntity::where('slug', 'LIKE', '/')->firstOrFail();
        } else {
            $seoEntity = SeoEntity::where('slug', 'LIKE', $route)->firstOrFail();
        }
        if (!$seoEntity) {
            abort(404);
        }

        $seoEntiteable = $seoEntity->seoEntiteable;

        if (!$seoEntiteable) {
            abort(404);
        }

        return App::make($seoEntity->controller)->callAction($seoEntity->action, [
            $request,
            $seoEntiteable
        ]);
    }
}
