<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $login = $request->input('login');
        $password = $request->input('password');

        if ($login === 'admin' && $password === '12345') {
            return redirect('/main?auth=success');
        }

        return back()->with('error', 'Wrong login or password');
    }

    public function showMain(Request $request)
    {
        $auth = $request->query('auth');
        return view('main', ['auth' => $auth]);
    }
}
