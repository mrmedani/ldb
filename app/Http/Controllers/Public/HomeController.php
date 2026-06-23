<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        return view('public.home');
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->query('search');
        $sortField = $request->query('sort_field', 'display_order');
        $sortDirection = $request->query('sort_direction', 'asc');

        // Validation simple des champs de tri
        $allowedSortFields = ['display_order', 'wilaya_id', 'company_name'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'display_order';
        }
        $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? strtolower($sortDirection) : 'asc';

        $offices = Office::with(['wilaya', 'commune'])
            ->visible()
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('wilaya', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('commune', fn($q) => $q->where('name', 'like', "%{$search}%"));
            }))
            ->orderBy($sortField, $sortDirection)
            ->get();

        $settings = Setting::getSettings();
        $logoBase64 = null;

        if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
            try {
                $logoPath = Storage::disk('public')->path($settings->logo);
                if (file_exists($logoPath)) {
                    $logoData = file_get_contents($logoPath);
                    $logoType = mime_content_type($logoPath);
                    $logoBase64 = 'data:' . $logoType . ';base64,' . base64_encode($logoData);
                }
            } catch (\Exception $e) {
                // Fallback
            }
        }

        $pdf = Pdf::loadView('pdf.offices', [
            'offices' => $offices,
            'settings' => $settings,
            'logoBase64' => $logoBase64,
            'search' => $search,
        ]);

        // Optionnel : Configurer des marges ou des orientations spécifiques
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('liste-des-bureaux.pdf');
    }
}
