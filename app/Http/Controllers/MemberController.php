<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isMember() && !$user->isManager() && !$user->isStaff() && !$user->isSuperAdmin()) {
            return redirect()->route('member.profile');
        }

        $members = Member::latest()->paginate(20);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:members,email',
            'phone'           => 'nullable|string|max:20',
            'membership_type' => 'required|string|max:50',
            'join_date'       => 'required|date',
            'status'          => 'required|string|in:active,expired,cancelled',
            'expiry_date'     => 'nullable|date',
        ]);

        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Member registered successfully.');
    }

    public function show(Member $member)
    {
        $user = Auth::user();

        if ($user->isMember() && !$user->hasAnyRole(['staff', 'manager', 'super_admin'])) {
            if ($user->email !== $member->email) {
                abort(403, 'You can only view your own profile.');
            }
        }

        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:members,email,' . $member->id,
            'phone'           => 'nullable|string|max:20',
            'membership_type' => 'required|string|max:50',
            'join_date'       => 'required|date',
            'status'          => 'required|string|in:active,expired,cancelled',
            'expiry_date'     => 'nullable|date',
        ]);

        $member->update($validated);

        return redirect()->route('members.show', $member)->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted.');
    }

    public function profile()
    {
        $member = Member::where('email', Auth::user()->email)->firstOrFail();
        return view('members.profile', compact('member'));
    }
}
