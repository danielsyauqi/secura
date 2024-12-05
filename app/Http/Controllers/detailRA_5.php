<?php

namespace App\Http\Controllers;

use App\Models\Assessment\RMSD;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Assessment\Threat;
use App\Models\Assessment\Valuation;
use App\Models\Management\AssetManagement;

class detailRA_5 extends Controller
{
    public function detailRA_5()
    {
        // Fetch all the models and assign them to variables
        $asset = AssetManagement::get();
        $threat = Threat::get();
        $valuation = Valuation::get();
        $rmsd = RMSD::get();

       

        // Group the assets by type
        $groupedAssets = ['Hardware', 'Software', 'Data and Information', 'Human Resources', 'Services', 'Work Process', 'Premise'];
        $assetsByType = [];

        foreach ($groupedAssets as $type) {
            $assetsByType[$type] = $asset->filter(function ($asset) use ($type) {
                return $asset->type == $type; // Group by 'type'
            });
        }

         // Prepare the data to be passed to the view
         $data = [
            'assets' => $asset,
            'threat' => $threat,
            'valuation' => $valuation,
            'rmsd' => $rmsd,
            'groupedAssets' => $groupedAssets,
            'assetsByType' => $assetsByType,
        ];

        // Pass the data correctly to the PDF view
        $pdf = Pdf::loadView('report.detailRA_5', $data);
        $pdf->set_paper('A4', 'landscape');

        // Stream the generated PDF to the browser
        return $pdf->stream('detail-risk-assessment-scale5-' . date('Y-m-d') . '.pdf');
    }
}
