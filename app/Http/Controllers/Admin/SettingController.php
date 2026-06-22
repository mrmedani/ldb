<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'nullable|string|max:100',
            'meta_description' => 'nullable|string|max:500',
            'hero_badge' => 'nullable|string|max:100',
            'hero_title' => 'nullable|string|max:500',
            'hero_subtitle' => 'nullable|string|max:1000',
            'search_placeholder' => 'nullable|string|max:200',
            'footer_copyright' => 'nullable|string|max:200',
            'footer_tagline' => 'nullable|string|max:200',
            'stats_wilayas_label' => 'nullable|string|max:100',
            'stats_offices_label' => 'nullable|string|max:100',
            'stats_partners_label' => 'nullable|string|max:100',
            'show_code' => 'boolean',
            'show_company' => 'boolean',
            'show_phone' => 'boolean',
            'show_address' => 'boolean',
            'show_maps' => 'boolean',
            'favicon' => 'nullable|file|mimes:ico,png,svg,jpg,jpeg|max:512',
            'logo' => 'nullable|image|mimes:png,svg,jpg,jpeg,webp|max:2048',
        ]);

        $settings = Setting::getSettings();

        if ($request->hasFile('favicon')) {
            if ($settings->favicon) {
                Storage::disk('public')->delete($settings->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('uploads', 'public');
        }

        if ($request->hasFile('logo')) {
            if ($settings->logo) {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = $request->file('logo')->store('uploads', 'public');
        }

        $settings->update($data);

        return redirect()->route('admin.settings')
            ->with('success', 'Paramètres mis à jour avec succès.');
    }
}
