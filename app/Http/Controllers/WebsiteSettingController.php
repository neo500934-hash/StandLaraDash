<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\WebsiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebsiteSettingController extends Controller
{
    /**
     * Show the form for editing the website settings.
     */
    public function edit(): View
    {
        return view('websettings', [
            'settings' => WebsiteSetting::current(),
            'ranks' => Rank::orderBy('rank_id')->get(),
        ]);
    }

    /**
     * Update the website settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ranks' => ['array'],
            'ranks.*' => ['nullable', 'string', 'max:255'],
        ]);

        WebsiteSetting::current()->update(['name' => $validated['name']]);

        $nextRankId = (int) Rank::max('rank_id') + 1;

        foreach (array_filter($validated['ranks'] ?? [], fn (?string $name) => filled($name)) as $name) {
            Rank::create(['rank_id' => $nextRankId++, 'name' => $name]);
        }

        return back()->with('status', __('Website settings updated.'));
    }
}
