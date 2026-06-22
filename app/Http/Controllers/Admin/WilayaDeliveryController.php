<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wilaya;
use Illuminate\Http\Request;

class WilayaDeliveryController extends Controller
{
    public function edit()
    {
        $wilayas = Wilaya::orderBy('code')->get();
        return view('admin.wilayas.delivery', compact('wilayas'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'wilayas' => 'required|array',
            'wilayas.*.id' => 'required|exists:wilayas,id',
            'wilayas.*.delivery_time' => 'nullable|string|max:100',
        ]);

        foreach ($data['wilayas'] as $item) {
            Wilaya::where('id', $item['id'])->update([
                'delivery_time' => $item['delivery_time'] ?? null,
            ]);
        }

        return redirect()->route('admin.wilayas.delivery')
            ->with('success', 'Délais de livraison mis à jour avec succès.');
    }
}
