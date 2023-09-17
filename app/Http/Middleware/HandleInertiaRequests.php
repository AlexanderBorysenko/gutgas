<?php

namespace App\Http\Middleware;

use App\Models\GlobalSettings;
use App\Models\SeoEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = Auth::user();

        $route = ltrim(str_replace(App::currentLocale(), '', request()->path()), '/');
        $urlParts = explode('/', $route);

        $urlPathesArray = [];
        for ($i = 0; $i < count($urlParts); $i++) {
            $urlPathesArray[] = implode('/', array_slice($urlParts, 0, $i + 1));
        }

        $breadcrumbs = collect($urlPathesArray)->map(function ($item, $key) {
            $seoEntity = SeoEntity::where('slug', 'LIKE', $item)->first();
            if ($seoEntity) {
                return [
                    'title' => $seoEntity->title,
                    'slug' => '/' . App::currentLocale() . '/' . $seoEntity->slug,
                ];
            }
        })->filter(function ($item) {
            return $item !== null;
        })->toArray();
        $homePage = SeoEntity::where('slug', 'LIKE', '/')->first();
        if ($homePage) array_unshift($breadcrumbs, [
            'title' => $homePage->title,
            'slug' => '/' . App::currentLocale()
        ]);

        if ($request->routeIs('logout')) $user = null;
        return array_merge(parent::share($request), [
            // message
            'message' => $request->session()->get('message'),

            'baseUrl' => url('/'),

            'auth' => [
                'user' => $user,
                'permissions' => $user ? $user->getAllPermissions()->pluck('name') : [],
            ],

            'breadcrumbs' => $breadcrumbs,

            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },

            'globalSettings' => function () {
                return GlobalSettings::all();
            },
        ]);
    }
}
