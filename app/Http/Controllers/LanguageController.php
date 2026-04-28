<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $lang): RedirectResponse
    {
        if (in_array($lang, ['en', 'ru', 'kz'], true)) {
            session(['locale' => $lang]);
        }

        return redirect()->back();
    }
}
