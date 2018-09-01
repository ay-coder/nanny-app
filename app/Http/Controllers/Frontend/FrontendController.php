<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(auth()->check() && access()->user()->user_type == 1) {
            return redirect()->route('frontend.user.parent.dashboard');
        } elseif (auth()->check() && access()->user()->user_type == 2) {
            return redirect()->route('frontend.user.sitter.dashboard');
        }

        return view('frontend.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function macros()
    {
        return view('frontend.macros');
    }

    /**
     * Support
     * @return [type] [description]
     */
    public function support()
    {
        return view('parent.support');
    }

    /**
     * aboutus
     * @return [type] [description]
     */
    public function aboutus()
    {
        return view('parent.about-us');
    }

    /**
     * services
     * @return [type] [description]
     */
    public function services()
    {
        return view('parent.services');
    }

    /**
     * Sitter Support
     * @return [type] [description]
     */
    public function contactus()
    {
        return view('parent.contact-us');
    }
}
