<?php

namespace App\Http\Controllers;

use App\Models\Assessment\RMSD;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Assessment\Threat;
use App\Models\Assessment\Valuation;
use App\Models\Management\AssetManagement;
use App\Orchid\Layouts\Assessment\SafeguardOptions;


class treatmentSummary extends Controller
{
    public function treatmentSummary()
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

          // Get safeguard options for all safeguard groups (S1, S2, S3, S4)
        $safeguardGroups = [
            "S1 Organizational Controls", 
            "S2 People Controls", 
            "S3 Physical Controls", 
            "S4 Technological Controls"
        ];

        // Initialize an array to hold safeguard options for each group
        $safeguardOptions = [];

        // Loop through each safeguard group and fetch options
        foreach ($safeguardGroups as $group) {
            $options = SafeguardOptions::getSafeguardIdOptions($group, 'Safeguard');
            // Filter out 'Select Safeguard' option
            $filteredOptions = array_filter($options, function($option) {
            return $option !== 'Select Safeguard';
            });
            $safeguardOptions[$group] = $filteredOptions;
        }
        // Pass the data correctly to the PDF view
        $pdf = Pdf::loadView('report.treatmentSummary', $data , compact('safeguardOptions'));
        $pdf->set_paper('A4', 'landscape');

        // Stream the generated PDF to the browser
        $currentDate = date('Y-m-d');
        return $pdf->stream('treatment-summary-' . $currentDate . '.pdf');
    }
}
