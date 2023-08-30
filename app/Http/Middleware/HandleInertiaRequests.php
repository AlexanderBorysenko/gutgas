<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use App\Models\GlobalSettings;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
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
        if ($request->routeIs('logout')) $user = null;
        return array_merge(parent::share($request), [
            // message
            'message' => $request->session()->get('message'),

            'baseUrl' => url('/'),

            'auth' => [
                'user' => $user,
                'permissions' => $user ? $user->getAllPermissions()->pluck('name') : [],
            ],

            'breadcrumbs' =>
            Breadcrumbs::exists($request->route()->getName())
                ? Breadcrumbs::generate($request->route()->getName(), $request->route()->parameters())
                : [],

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
