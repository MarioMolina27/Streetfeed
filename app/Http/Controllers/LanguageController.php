<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function setLanguage($lang)
    {
        return redirect()->back()->withCookie(cookie()->forever('lang', $lang));
    }
}
