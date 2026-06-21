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
