<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Role;

class DashboardController extends Controller
{
    /** Super Admin dashboard */
    public function admin()
    {
        return view('admin.dashboard', [
            'totalMembers'  => Member::count(),
            'activeMembers' => Member::where('status', 'active')->count(),
            'expiringSoon'  => Member::where('status', 'active')->where('expiry_date', '<', now()->addDays(7))->count(),
            'staffCount'    => Role::where('name', 'staff')->withCount('users')->first()?->users_count ?? 0,
            'recentMembers' => Member::latest()->take(8)->get(),
            'roles'         => Role::withCount('users')->get(),
        ]);
    }

    /** Manager dashboard */
    public function manager()
    {
        return view('manager.dashboard', [
            'totalMembers' => Member::count(),
            'goldCount'    => Member::where('membership_type', 'Gold')->where('status', 'active')->count(),
            'silverCount'  => Member::where('membership_type', 'Silver')->where('status', 'active')->count(),
            'bronzeCount'  => Member::where('membership_type', 'Bronze')->where('status', 'active')->count(),
            'members'      => Member::latest()->paginate(15),
        ]);
    }

    /** Manager reports */
    public function reports()
    {
        $membershipData = [
            'Gold' => Member::where('membership_type', 'Gold')->count(),
            'Silver' => Member::where('membership_type', 'Silver')->count(),
            'Bronze' => Member::where('membership_type', 'Bronze')->count(),
        ];

        $statusData = [
            'Active' => Member::where('status', 'active')->count(),
            'Expired' => Member::where('status', 'expired')->count(),
            'Cancelled' => Member::where('status', 'cancelled')->count(),
        ];

        $recentJoins = Member::selectRaw('DATE(join_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(7)
            ->get()
            ->reverse();

        return view('manager.reports', compact('membershipData', 'statusData', 'recentJoins'));
    }

    /** Staff dashboard */
    public function staff()
    {
        return view('staff.dashboard', [
            'totalMembers' => Member::count(),
            'todayCount'   => Member::whereDate('created_at', today())->count(),
            'members'      => Member::latest()->paginate(20),
        ]);
    }
}
