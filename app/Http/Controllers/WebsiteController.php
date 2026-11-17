<?php

namespace App\Http\Controllers;

use App\Models\websites;

class WebsiteController extends Controller
{
    public function template1(string $slug)
    {
        $website = websites::with('template')->where('slug', $slug)->firstOrFail();

        if ($website->template->name_template === 'Template 1') {
            return view('template.template1', compact('website'));
        }

        abort(404);
    }
}