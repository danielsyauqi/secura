<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;


class highRecommend_5 extends Controller
{
    public function highRecommend_5()
    {   

        // Pass the data correctly to the PDF view
        $pdf = Pdf::loadView('report.highRecommend_5');
        $pdf->set_paper('A4', 'landscape');

        // Stream the generated PDF to the browser
        $currentDate = date('Y-m-d');
        return $pdf->stream('high-recommendation-scale5-' . $currentDate . '.pdf');
    }
}
