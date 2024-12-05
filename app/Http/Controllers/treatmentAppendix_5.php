<?php

namespace App\Http\Controllers;

use App\Models\Assessment\RMSD;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Assessment\Threat;
use App\Models\Assessment\Valuation;
use App\Models\Management\AssetManagement;


class treatmentAppendix_5 extends Controller
{
    public function treatmentAppendix_5()
    {   
          // Fetch all the models and assign them to variables
          $asset = AssetManagement::get();
          $threat = Threat::get();
          $valuation = Valuation::get();
          $rmsd = RMSD::get();
  
          // Prepare the data to be passed to the view
          $data = [
              'assets' => $asset,
              'threat' => $threat,
              'valuation' => $valuation,
              'rmsd' => $rmsd,
          ];
        // Pass the data correctly to the PDF view
        $pdf = Pdf::loadView('report.treatmentAppendix_5', $data);
        $pdf->set_paper('A4', 'landscape');

        // Stream the generated PDF to the browser
        $currentDate = date('Y-m-d');
        return $pdf->stream('treatment-appendix-' . $currentDate . '.pdf');
    }
}
