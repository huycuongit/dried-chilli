<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function faq()
    {
        $faqs = \App\Models\Faq::where('is_active', true)->orderBy('sort_order')->get();
        return view('frontend.legal.faq', compact('faqs'));
    }

    public function shipping()
    {
        return view('frontend.legal.shipping');
    }

    public function privacy()
    {
        return view('frontend.legal.privacy');
    }

    public function terms()
    {
        return view('frontend.legal.terms');
    }
}
