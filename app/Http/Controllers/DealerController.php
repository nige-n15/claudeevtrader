<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DealerController extends Controller
{
    /**
     * Display the dealer dashboard
     */
    public function dashboard(Request $request): Response
    {
        $user = $request->user();

        // Get the active dealer (admin's current dealer or dealer user's dealer)
        $dealer = $user->active_dealer;

        if (! $dealer) {
            // If admin hasn't selected a dealer yet, show dealer selection
            if ($user->isAdmin()) {
                return Inertia::render('Dealer/SelectDealer', [
                    'dealers' => Dealer::active()->get(),
                ]);
            }

            abort(403, 'You are not associated with any dealer.');
        }

        // Load dealer relationships
        $dealer->load(['subscription', 'vehicles', 'leads']);

        // Calculate stats
        $stats = [
            'total_vehicles' => $dealer->vehicles()->count(),
            'active_vehicles' => $dealer->vehicles()->where('status', 'available')->count(),
            'reserved_vehicles' => $dealer->vehicles()->where('status', 'reserved')->count(),
            'sold_vehicles' => $dealer->vehicles()->where('status', 'sold')->count(),
            'total_leads' => $dealer->leads()->count(),
            'new_leads' => $dealer->leads()->where('status', 'new')->count(),
            'contacted_leads' => $dealer->leads()->where('status', 'contacted')->count(),
            'won_leads' => $dealer->leads()->where('status', 'won')->count(),
            'total_views' => $dealer->vehicles()->sum('views_count'),
        ];

        // Recent leads
        $recentLeads = $dealer->leads()
            ->with(['vehicle', 'assignedTo'])
            ->latest()
            ->limit(10)
            ->get();

        // Featured vehicles
        $featuredVehicles = $dealer->vehicles()
            ->with('images')
            ->where('status', 'available')
            ->where('featured', true)
            ->latest()
            ->limit(6)
            ->get();

        return Inertia::render('Dealer/Dashboard', [
            'dealer' => $dealer,
            'stats' => $stats,
            'recentLeads' => $recentLeads,
            'featuredVehicles' => $featuredVehicles,
            'subscription' => $dealer->subscription,
        ]);
    }

    /**
     * Switch to a different dealer (admin only)
     */
    public function switchDealer(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            abort(403, 'Only administrators can switch dealers.');
        }

        $validated = $request->validate([
            'dealer_id' => 'nullable|exists:dealers,id',
        ]);

        $request->user()->switchToDealer($validated['dealer_id'] ?? null);

        return redirect()->route('dealer.dashboard');
    }

    /**
     * Get list of all dealers (for admin switching)
     */
    public function index(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        return Inertia::render('Dealer/Index', [
            'dealers' => Dealer::active()->withCount(['vehicles', 'leads'])->get(),
        ]);
    }
}
