<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function home(Request $request): View
    {
        return view('public.home', ['auth' => $request->query('auth')]);
    }

    public function about(): View
    {
        return view('public.about');
    }

    public function services(): View
    {
        return view('public.services');
    }

    public function schedule(): View
    {
        return view('public.schedule');
    }

    public function pricing(): View
    {
        return view('public.pricing');
    }

    public function contact(): View
    {
        return view('public.contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        return back()->with('success', __('public.contact.success'));
    }
}
