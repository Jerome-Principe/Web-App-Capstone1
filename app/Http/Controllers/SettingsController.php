<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display the settings page (redirects to terms and conditions by default)
     */
    public function index()
    {
        return redirect()->route('settings.terms');
    }

    /**
     * Display the Terms & Conditions page
     */
    public function terms()
    {
        return view('settings.terms');
    }

    /**
     * Display the Guidelines page
     */
    public function guidelines()
    {
        return view('settings.guidelines');
    }

    /**
     * Display the Privacy Policy page
     */
    public function privacy()
    {
        return view('settings.privacy');
    }

    /**
     * Display the Community Standards page
     */
    public function community()
    {
        return view('settings.community');
    }
}
