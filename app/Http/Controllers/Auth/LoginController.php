<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if ($request->user()->role === 'member' && $request->user()->approval_status !== 'approved') {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Your account is waiting for gym admin approval.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            if ($request->user()->role === 'member') {
                $alreadyCheckedIn = AttendanceRecord::where('user_id', $request->user()->id)
                    ->whereDate('checked_in_at', today())
                    ->exists();

                if (! $alreadyCheckedIn) {
                    AttendanceRecord::create([
                        'user_id' => $request->user()->id,
                        'checked_in_at' => now(),
                        'source' => 'login',
                    ]);
                }
            }

            return redirect()->intended($request->user()->role === 'admin' ? '/admin/dashboard' : '/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ])->onlyInput('email');
    }
}