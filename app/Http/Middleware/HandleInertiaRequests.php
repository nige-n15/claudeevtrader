<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
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
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->role,
                    'dealer_id' => $request->user()->dealer_id,
                    'current_dealer_id' => $request->user()->current_dealer_id,
                    'is_admin' => $request->user()->isAdmin(),
                    'is_dealer' => $request->user()->isDealer(),
                    'is_customer' => $request->user()->isCustomer(),
                    'can_access_dealer_dashboard' => $request->user()->canAccessDealerDashboard(),
                ] : null,
                'active_dealer' => $request->user()?->active_dealer,
            ],
        ];
    }
}
