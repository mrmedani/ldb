<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OfficesExport;
use App\Http\Controllers\Controller;
use App\Models\Office;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function excel()
    {
        return Excel::download(new OfficesExport, 'bureaux.xlsx');
    }

    public function pdf()
    {
        $offices = Office::with(['wilaya', 'commune'])->ordered()->get();
        $pdf = Pdf::loadView('admin.exports.offices-pdf', ['offices' => $offices]);
        return $pdf->download('bureaux.pdf');
    }

    public function print()
    {
        $offices = Office::with(['wilaya', 'commune'])->ordered()->get();
        return view('admin.exports.offices-print', ['offices' => $offices]);
    }
}
