<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

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
    public function version(Request $request): ?string
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
        $shared_data = [
            ...parent::share($request),
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
                'auth' => [
                    'background' => asset(config('imperium.media.image.auth.background')),
                ],
            ],
        ];
        if (Auth::guard('web')->check()) {
            $authenticatedUser = $request->user('web');

            $resources = resources();
            $headers = Arr::collapse(array_column($resources, 'headers'));
            $route_name = $request->route()->getName();
            $header = collect($headers)->where('for', $route_name)->first();

            $authenticated_data = [
                'imperium' => config('imperium'),
                'auth' => [
                    'user' => $authenticatedUser,
                    'csrf_token' => csrf_token(),
                ],
                'request' => [
                    'urlParams' => $request->query(),
                ],
                'menuItems' => menus(),
                'resources' => $resources,
                'header' => $header ?? null,
                'can' => [
                    'viewAny' => ! is_null($authenticatedUser) ? ifUserCanForAllModules($authenticatedUser, 'viewAny') : null,
                    'create' => ! is_null($authenticatedUser) ? ifUserCanForAllModules($authenticatedUser, 'create') : null,
                ],
            ];

            $shared_data = array_merge($shared_data, $authenticated_data);
        } else {
            $authenticatedUser = null;
        }

        return $shared_data;
    }
}
