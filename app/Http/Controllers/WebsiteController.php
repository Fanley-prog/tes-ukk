<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\websites;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function template1(Request $request, string $slug)
    {
        $website = websites::with('template')->where('slug', $slug)->firstOrFail();

        /** @var User|null $user */
        $user = $request->user();

        if (! $website->is_published && ! $user?->isSuperAdmin()) {
            abort(404);
        }

        if ($website->template->name_template === 'Template 1') {
            return view('template.template1', compact('website'));
        }

        abort(404);
    }
}