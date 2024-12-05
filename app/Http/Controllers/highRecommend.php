<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;


class highRecommend extends Controller
{
    public function highRecommend()
    {   

        // Pass the data correctly to the PDF view
        $pdf = Pdf::loadView('report.highRecommend');
        $pdf->set_paper('A4', 'landscape');

        // Stream the generated PDF to the browser
        $currentDate = date('Y-m-d');
        return $pdf->stream('high-recommendation-' . $currentDate . '.pdf');
    }
}
