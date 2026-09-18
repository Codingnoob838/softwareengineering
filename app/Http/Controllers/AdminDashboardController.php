<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'pendingMembers' => User::where('role', 'member')->where('approval_status', 'pending')->latest()->get(),
            'members' => User::where('role', 'member')->with('memberships')->latest()->get(),
            'todayCheckIns' => AttendanceRecord::whereDate('checked_in_at', today())->count(),
        ]);
    }

    public function memberships(): View
    {
        return view('admin.memberships', [
            'members' => User::where('role', 'member')->with('memberships')->latest()->get(),
        ]);
    }

    public function members(): View
    {
        return view('admin.members.index', [
            'members' => User::where('role', 'member')->with('memberships')->latest()->get(),
        ]);
    }

    public function checkIns(): View
    {
        return view('admin.check-ins', [
            'checkIns' => AttendanceRecord::with('user')->latest('checked_in_at')->get(),
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        abort_if($user->role !== 'member', 404);

        $user->update(['approval_status' => 'approved']);
        $membership = $user->memberships()->first();
        $startsAt = today();
        $endsAt = match ($membership?->plan) {
            'Weekly' => $startsAt->copy()->addDays(7),
            'Walk-in' => $startsAt->copy(),
            default => $startsAt->copy()->addMonth(),
        };

        Membership::updateOrCreate(
            ['user_id' => $user->id],
            [
                'plan' => $membership?->plan ?? 'Monthly',
                'status' => 'active',
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
            ],
        );

        return back()->with('success', $user->name.' has been approved.');
    }

    public function edit(User $user): View
    {
        abort_if($user->role !== 'member', 404);

        return view('admin.members.edit', [
            'member' => $user->load('memberships'),
            'membership' => $user->memberships->first(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_if($user->role !== 'member', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'approval_status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'plan' => ['required', 'string', 'max:100'],
            'membership_status' => ['required', Rule::in(['pending', 'active', 'expired', 'cancelled'])],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'approval_status' => $validated['approval_status'],
        ]);

        Membership::updateOrCreate(
            ['user_id' => $user->id],
            [
                'plan' => $validated['plan'],
                'status' => $validated['membership_status'],
                'starts_at' => $validated['starts_at'],
                'ends_at' => $validated['ends_at'],
            ],
        );

        return redirect()->route('admin.dashboard')->with('success', $user->name.' account updated.');
    }

    public function remove(User $user): RedirectResponse
    {
        abort_if($user->role !== 'member', 404);

        $user->delete();

        return back()->with('success', 'Member account deleted.');
    }
}