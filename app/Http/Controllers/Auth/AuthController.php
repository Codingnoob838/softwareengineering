<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showDashboard(): View
    {
        return view('auth.dashboard');
    }
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'membership_plan' => ['required', 'in:Monthly,Weekly,Walk-in'],
        ]);

        $user = User::create($validated + [
            'role' => 'member',
            'approval_status' => 'pending',
        ]);
        Membership::create([
            'user_id' => $user->id,
            'plan' => $validated['membership_plan'],
            'status' => 'pending',
        ]);

        return redirect()->route('login')->with('success', 'Account created. Please wait for gym admin approval before logging in.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}