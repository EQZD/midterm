<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Wrong email or password');
        }

        $user = Auth::user();


        return match (true) {
            $user->isSuperAdmin() => redirect()->route('admin.dashboard'),
            $user->isManager()    => redirect()->route('manager.dashboard'),
            $user->isStaff()      => redirect()->route('staff.dashboard'),
            $user->isMember()     => redirect()->route('main'),
            default => redirect()->route('main'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showMain(Request $request)
    {
        return view('public.home', ['auth' => $request->query('auth')]);
    }
}
