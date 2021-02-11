<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Question;

class PdfController extends Controller
{
    public function adminPdf($id)
    {
        $data = ['jobayer'];
        $pdf = PDF::loadView('invoice', $data);
        return $pdf->download('invoice.pdf');
    }
}
