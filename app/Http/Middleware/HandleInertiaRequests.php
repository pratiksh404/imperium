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
        if (Auth::guard('web')->check()) {
            $authenticatedUser = $request->user('web');
        } else {
            $authenticatedUser = null;
        }

        $resources = resources();
        $breadcrumbs = Arr::collapse(array_column($resources, 'breadcrumbs'));
        $route_name = $request->route()->getName();
        $breadcrumb = collect($breadcrumbs)->where('for', $route_name)->first();

        return [
            ...parent::share($request),
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
            ],
            'imperium' => config('imperium'),
            'auth' => [
                'user' => $authenticatedUser,
                'csrf_token' => csrf_token(),
            ],
            'request' => [
                'urlParams' => $request->query(),
            ],
            'menus' => menus(),
            'resources' => $resources,
            'breadcrumb' => $breadcrumb ?? null,
            'can' => [
                'viewAny' => ! is_null($authenticatedUser) ? ifUserCanForAllModules($authenticatedUser, 'viewAny') : null,
                'create' => ! is_null($authenticatedUser) ? ifUserCanForAllModules($authenticatedUser, 'create') : null,
            ],
        ];
    }
}
