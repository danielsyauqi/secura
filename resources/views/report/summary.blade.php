<!DOCTYPE html>
<html>
<head>

    <title>Asset Summary Report</title>
    <style>
                /* Set the default font family for the entire document */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px; /* Adjusted font size for better readability */
        }

        /* Header and data cell styling */
        th, td {
            border: 1px solid #000;
            padding: 6px 8px; /* Apply uniform padding for both rows and columns */
            text-align: center;
            vertical-align: middle; /* Align text vertically to the middle */
        }

        /* Ensure padding is applied to the data cells, and no additional margins are added */
        td {
            padding: 6px 8px; /* More padding for better readability */
            margin: 0; /* Ensure no margin */
        }

        /* Header styling */
        th {
            background-color: #d1dff6;
            font-weight: bold;
            vertical-align: middle; /* Align header text to the middle */
        }

        .header {
            text-align: left; /* Align text and logo to the left */
            margin-bottom: 10px; /* Reduce bottom margin */
        }

        .header img {
            width: 70px; /* Adjust width for logo */
            height: auto;
            display: inline-block; /* Ensure the logo and title are inline */
            vertical-align: middle; /* Align logo with text */
        }

        .header h1 {
            margin: 0; /* Remove any margin for title */
            font-size: 12px; /* Adjust font size for the title */
            color: #333;
            font-weight: bold;
        }

        .header p {
            margin: 0; /* Remove margin for subtitle */
            font-size: 10px; /* Adjust font size for the subtitle */
        }

        .header-1 {
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }



        /* Optional: Ensures the content inside cells aligns properly */
        td, th {
            white-space: normal;
        }

        /* Footer styling */
        .pagenum {
            position: fixed;
            bottom: -50px;
            width: 100%;
            text-align: center;
            font-size: 8px;
            padding: 10px;
        }


        .pagenum:after {
        content: counter(page);
        }

        /* Page Margin settings */
        @page {
            margin-top: 110px;
            margin-bottom: 110px;
        }
        header{
                position: fixed;
                left: 0px;
                right: 0px;
                height: 150px;
                margin-top: -50px;
        }

        .title{
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 10px;
        }

        .title p{
            font-size: 11px;
        }

        .total{
            background-color: #ffff97;
            font-weight: bold;
        }


    </style>


</head>
<body>
    <!-- front page -->
    <div style="page-break-after: always;">
        <h3 style="text-align:left; font-size:12px; margin-left: 10px;">SULIT</h3>


        <div style="text-align: center; margin-top: 200px">
            <img src="{{ public_path('/default-logo.png') }}" alt="Malaysian Nuclear Agency Logo" style="width: 250px; height: auto;">
            <h1>Malaysian Nuclear Agency</h1>
            <h2>Summary Report Appendix</h2>
            <p>Date: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        </div>

    </div>
    
    <!-- header -->
    <header>
        <div class="header">
            <img src="{{ public_path('/default-logo.png') }}" alt="">
            <div class="header-1">
                <h1>Malaysian Nuclear Agency</h1>
                <p>Summary Report Appendix</p>
            </div>
        </div>
    <hr>
    </header>

    <span class="pagenum">Page </span>
    
    
    <!-- Appendix A -->
    <div style="page-break-after: always;">
        <div class= "title">
            <h3 style="text-align:left;">SULIT</h3>
            <h2>Appendix A - Asset Classification and Valuation</h2>
            <br>
            <p>Table A-1: Asset Value Based on Asset Group</p>
        </div>

        <!-- Table Section -->
        <table>
            <thead>
                <tr>
                    <th rowspan ="2">Asset Type</th>
                    <th colspan="3">Asset Value</th>
                    <th rowspan ="2">Asset Count</th>
                </tr>
                <tr>
                    <th style="width: 15%;">Low</th>
                    <th style="width: 15%;">Medium</th>
                    <th style="width: 15%;">High</th>
                </tr>
            </thead>
            <tbody>
                    @php

                    // Fetching data for asset types, ensuring all types are included even if no associated data exists
                    $assets = DB::table('asset_management')
                        ->join('asset_valuation', 'asset_management.id', '=', 'asset_valuation.asset_id')
                        ->select('asset_management.type', 
                            DB::raw('SUM(CASE WHEN asset_valuation.asset_value = "Low" THEN 1 ELSE 0 END) as Low'), 
                            DB::raw('SUM(CASE WHEN asset_valuation.asset_value = "Medium" THEN 1 ELSE 0 END) as Medium'), 
                            DB::raw('SUM(CASE WHEN asset_valuation.asset_value = "High" THEN 1 ELSE 0 END) as High'), 
                            DB::raw('COUNT(*) as count'))
                        ->whereIn('asset_management.type', ['Hardware', 'Software', 'Data and Information', 'Human Resources', 'Services', 'Work Process', 'Premise']) // Fetch only these types
                        ->groupBy('asset_management.type')
                        ->get();

                    // Define all asset types to ensure none are missing
                    $allAssetTypes = ['Hardware', 'Software', 'Data and Information', 'Human Resources', 'Services', 'Work Process', 'Premise'];

                    // Re-index the result by asset type
                    $assets = $assets->keyBy('type');

                    // Add missing asset types with zero values if they don't exist in the data
                    foreach ($allAssetTypes as $type) {
                        if (!isset($assets[$type])) {
                            $assets[$type] = (object) [
                                'type' => $type,
                                'Low' => 0,
                                'Medium' => 0,
                                'High' => 0,
                                'count' => 0
                            ];
                        }
                    }

                    // Re-sort the assets to match the predefined order
                    $assets = collect($assets)->sortBy(function($asset) use ($allAssetTypes) {
                        return array_search($asset->type, $allAssetTypes);
                    });
                @endphp


                 @foreach($assets as $asset)
                    <tr>
                        <td>{{ $asset->type }}</td>
                        <td>{{ $asset->Low }}</td>
                        <td>{{ $asset->Medium }}</td>
                        <td>{{ $asset->High }}</td>
                        <td>{{ $asset->Low + $asset->Medium + $asset->High}} / {{ $asset->count }}</td>
                    </tr>
                @endforeach


                   <!-- Display the total row -->
                <tr class="total">
                    <td>Total</td>
                    <td>{{ $assets->sum('Low') }}</td>
                    <td>{{ $assets->sum('Medium')  }}</td>
                    <td>{{ $assets->sum('High') }}</td>
                    <td>{{ $assets->sum('Low') +  $assets->sum('Medium') + $assets->sum('High')}} / {{ $assets->sum('count')  }}</td>
                </tr>


            </tbody>
        </table>
    </div>



    <!-- Appendix B -->                
    <div style="page-break-after: always;">
        <div class= "title">
            <h3 style="text-align:left;">SULIT</h3>
            <h2>Appendix B - Threat, Vulnerability and Safeguard Analysis</h2>
            <br>
            <p>Table B-1: Asset Group against Threat Group Occurrence
            </p>
        </div>

        <!-- Table Section -->
        <table>
            <thead>
                <tr>
                    <th rowspan ="2">Threat Group</th>
                    <th colspan="7">Asset Group</th>
                    <th rowspan ="2">Threat Group Occurrence</th>
                </tr>
                <tr>
                    <th style="width: 5%;">Hardware</th>
                    <th style="width: 5%;">Software</th>
                    <th style="width: 5%;">Data and Information</th>
                    <th style="width: 5%;">Human Resources</th>
                    <th style="width: 5%;">Services</th>
                    <th style="width: 5%;">Work Process</th>
                    <th style="width: 5%;">Premise</th>

                </tr>
            </thead>
            <tbody>
                    @php
                        // Fetch the number of asset types per threat group
                        $threatGroups = DB::table('asset_threat')
                            ->join('asset_management', 'asset_threat.asset_id', '=', 'asset_management.id') // Join with asset_management table
                            ->select('asset_threat.threat_group',
                                DB::raw('SUM(CASE WHEN asset_management.type = "Hardware" THEN 1 ELSE 0 END) as Hardware'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Software" THEN 1 ELSE 0 END) as Software'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Data and Information" THEN 1 ELSE 0 END) as DataAndInformation'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Human Resources" THEN 1 ELSE 0 END) as HumanResources'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Services" THEN 1 ELSE 0 END) as Services'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Work Process" THEN 1 ELSE 0 END) as WorkProcess'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Premise" THEN 1 ELSE 0 END) as Premise')
                            )
                            ->whereIn('asset_threat.threat_group', ['T1 Physical Threats', 'T2 Natural Threats', 'T3 Infrastructure Threats', 'T4 Technical Failures', 'T5 Human Actions', 'T6 Organizational Threats'])
                            ->groupBy('asset_threat.threat_group')
                            ->get();

                        // Define all threat groups to ensure none are missing
                        $allThreatGroups = [
                            'T1 Physical Threats',
                            'T2 Natural Threats',
                            'T3 Infrastructure Threats',
                            'T4 Technical Failures',
                            'T5 Human Actions',
                            'T6 Organizational Threats'
                        ];

                        // Make sure all threat groups are included, even if some don't have associated assets
                        $threatGroups = $threatGroups->keyBy('threat_group');

                        // Add missing threat groups with zero values if they don't exist in the data
                        foreach ($allThreatGroups as $group) {
                            if (!isset($threatGroups[$group])) {
                                $threatGroups[$group] = (object) [
                                    'threat_group' => $group,
                                    'Hardware' => 0,
                                    'Software' => 0,
                                    'DataAndInformation' => 0,
                                    'HumanResources' => 0,
                                    'Services' => 0,
                                    'WorkProcess' => 0,
                                    'Premise' => 0
                                ];
                            }
                        }

                        // Reindex the collection to maintain the correct order
                        $threatGroups = $threatGroups->sortKeys();
                    @endphp



                    @foreach($threatGroups as $threatGroup)
                    <tr>
                        <td>{{ $threatGroup->threat_group }}</td>
                        <td>{{ $threatGroup->Hardware ?? 0 }}</td>
                        <td>{{ $threatGroup->Software ?? 0 }}</td>
                        <td>{{ $threatGroup->DataAndInformation ?? 0 }}</td>
                        <td>{{ $threatGroup->HumanResources ?? 0 }}</td>
                        <td>{{ $threatGroup->Services ?? 0 }}</td>
                        <td>{{ $threatGroup->WorkProcess ?? 0 }}</td>
                        <td>{{ $threatGroup->Premise ?? 0 }}</td>
                        <td>
                            @php
                                // Sum the values for all asset types
                                $totalAssets = ($threatGroup->Hardware ?? 0) 
                                            + ($threatGroup->Software ?? 0) 
                                            + ($threatGroup->DataAndInformation ?? 0) 
                                            + ($threatGroup->HumanResources ?? 0) 
                                            + ($threatGroup->Services ?? 0) 
                                            + ($threatGroup->WorkProcess ?? 0) 
                                            + ($threatGroup->Premise ?? 0);
                            @endphp
                            {{ $totalAssets }}
                        </td>
                    </tr>
                    @endforeach


            </tbody>
        </table>

    <!-- Table B-2 -->                

        <div class= "title">
            <p>Table B-2: : Asset Group against Threat Group Occurrence
            </p>
        </div>

        <!-- Table Section -->
        <table>
            <thead>
                <tr>
                    <th rowspan ="2">Vulnerability Group</th>
                    <th colspan="7">Asset Group</th>
                    <th rowspan ="2">Vulnerability Group Occurrence</th>
                </tr>
                <tr>
                    <th style="width: 5%;">Hardware</th>
                    <th style="width: 5%;">Software</th>
                    <th style="width: 5%;">Data and Information</th>
                    <th style="width: 5%;">Human Resources</th>
                    <th style="width: 5%;">Services</th>
                    <th style="width: 5%;">Work Process</th>
                    <th style="width: 5%;">Premise</th>

                </tr>
            </thead>
            <tbody>
                    @php
                        // Fetch the number of asset types per threat group (vulnerability group)
                        $vulnGroups = DB::table('asset_threat')
                            ->join('asset_management', 'asset_threat.asset_id', '=', 'asset_management.id') // Join asset_threat with asset_management
                            ->join('asset_rmsd', 'asset_threat.id', '=', 'asset_rmsd.threat_id') // Join asset_threat with asset_rmsd
                            ->select('asset_rmsd.vuln_group',
                                DB::raw('SUM(CASE WHEN asset_management.type = "Hardware" THEN 1 ELSE 0 END) as Hardware'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Software" THEN 1 ELSE 0 END) as Software'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Data and Information" THEN 1 ELSE 0 END) as DataAndInformation'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Human Resources" THEN 1 ELSE 0 END) as HumanResources'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Services" THEN 1 ELSE 0 END) as Services'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Work Process" THEN 1 ELSE 0 END) as WorkProcess'),
                                DB::raw('SUM(CASE WHEN asset_management.type = "Premise" THEN 1 ELSE 0 END) as Premise')
                            )
                            ->whereIn('asset_rmsd.vuln_group', ['V1 Hardware', 'V2 Software', 'V3 Network', 'V4 Personnel', 'V5 Site', 'V6 Organization'])
                            ->groupBy('asset_rmsd.vuln_group') // Group by vulnerability type
                            ->get();

                        // Define all vulnerability groups to ensure none are missing
                        $allVulnGroup = [
                            'V1 Hardware',
                            'V2 Software',
                            'V3 Network',
                            'V4 Personnel',
                            'V5 Site',
                            'V6 Organization'
                        ];

                        // Ensure that all vulnerability groups are included, even if some don't have associated assets
                        $vulnGroups = $vulnGroups->keyBy('vuln_group');

                        // Add missing groups with zero values if they don't exist in the data
                        foreach ($allVulnGroup as $group) {
                            if (!isset($vulnGroups[$group])) {
                                $vulnGroups[$group] = (object) [
                                    'vuln_group' => $group,
                                    'Hardware' => 0,
                                    'Software' => 0,
                                    'DataAndInformation' => 0,
                                    'HumanResources' => 0,
                                    'Services' => 0,
                                    'WorkProcess' => 0,
                                    'Premise' => 0
                                ];
                            }
                        }

                        // Reindex to maintain the correct order
                        $vulnGroups = $vulnGroups->sortKeys();
                    @endphp




                    @foreach($vulnGroups as $threatGroup)
                        <tr>
                            <td>{{ $threatGroup->vuln_group }}</td>
                            <td>{{ $threatGroup->Hardware ?? 0 }}</td>
                            <td>{{ $threatGroup->Software ?? 0 }}</td>
                            <td>{{ $threatGroup->DataAndInformation ?? 0 }}</td>
                            <td>{{ $threatGroup->HumanResources ?? 0 }}</td>
                            <td>{{ $threatGroup->Services ?? 0 }}</td>
                            <td>{{ $threatGroup->WorkProcess ?? 0 }}</td>
                            <td>{{ $threatGroup->Premise ?? 0 }}</td>

                            <!-- Calculate the total asset occurrences for the current vulnerability group -->
                            <td>
                                @php
                                    $totalAssets = ($threatGroup->Hardware ?? 0) 
                                                + ($threatGroup->Software ?? 0) 
                                                + ($threatGroup->DataAndInformation ?? 0) 
                                                + ($threatGroup->HumanResources ?? 0) 
                                                + ($threatGroup->Services ?? 0) 
                                                + ($threatGroup->WorkProcess ?? 0) 
                                                + ($threatGroup->Premise ?? 0);
                                @endphp
                                {{ $totalAssets }}
                            </td>
                        </tr>
                    @endforeach

            </tbody>
            
        </table>
    </div>

    <div style="page-break-after: always;">

    <div class= "title">
            <h3 style="text-align:left;">SULIT</h3>
            <h2>Appendix C - Business Impact Analysis</h2>
            <br>
            <p>Table C-1:  Asset Group against Impact Level</p>
        </div>

        <!-- Table Section -->
        <table>
            <thead>
                <tr>
                    <th rowspan ="2">Asset Group</th>
                    <th colspan="3">Impact Level</th>
                </tr>
                <tr>
                    <th style="width: 15%;">Low</th>
                    <th style="width: 15%;">Medium</th>
                    <th style="width: 15%;">High</th>
                </tr>
            </thead>
            <tbody>
                    @php

                        // Define the custom order for the asset types
                        $customOrder = ['Hardware', 'Software', 'Data and Information', 'Human Resources', 'Services', 'Work Process', 'Premise'];

                        // Fetch the number of asset types per vulnerability group (type) and impact level
                        $impactLevels = DB::table('asset_threat')
                            ->join('asset_management', 'asset_threat.asset_id', '=', 'asset_management.id') // Join with asset_management
                            ->join('asset_rmsd', 'asset_threat.id', '=', 'asset_rmsd.threat_id') // Join with asset_rmsd
                            ->select('asset_management.type',
                                DB::raw('SUM(CASE WHEN asset_rmsd.impact_level = "Low" THEN 1 ELSE 0 END) as Low'),
                                DB::raw('SUM(CASE WHEN asset_rmsd.impact_level = "Medium" THEN 1 ELSE 0 END) as Medium'),
                                DB::raw('SUM(CASE WHEN asset_rmsd.impact_level = "High" THEN 1 ELSE 0 END) as High')
                            )
                            ->whereIn('asset_management.type', $customOrder) // Fetch only specified types
                            ->groupBy('asset_management.type') // Group by asset type (e.g., Hardware, Software)
                            ->get();

                        // Convert the fetched data into an associative array for easy access
                        $impactLevels = $impactLevels->keyBy('type');

                        // Ensure that all asset types are included, even if some don't have associated assets
                        foreach ($customOrder as $group) {
                            if (!isset($impactLevels[$group])) {
                                $impactLevels[$group] = (object) [
                                    'type' => $group,
                                    'Low' => 0,
                                    'Medium' => 0,
                                    'High' => 0
                                ];
                            }
                        }

                        // Reindex to maintain the correct order based on the $customOrder
                        $impactLevels = collect($impactLevels)->sortBy(function ($item) use ($customOrder) {
                            return array_search($item->type, $customOrder);
                        });
                    @endphp



                     @foreach($impactLevels as $impactLevel)
                        <tr>
                            <td>{{ $impactLevel->type }}</td>
                            <td>{{ $impactLevel->Low ?? 0 }}</td>
                            <td>{{ $impactLevel->Medium ?? 0 }}</td>
                            <td>{{ $impactLevel->High ?? 0 }}</td>
                        </tr>


                    @endforeach
        

                <tr class="total">
                    <td>Total</td>
                    <td>{{ $impactLevels->sum('Low')  }}</td>
                    <td>{{ $impactLevels->sum('Medium')}}</td>
                    <td>{{ $impactLevels->sum('High') }}</td>
                </tr>


            </tbody>
        </table>


    </div>

    <div class= "title">
            <h3 style="text-align:left;">SULIT</h3>
            <h2>Appendix D - Overall Risk Analysis Distribution</h2>
            <br>
            <p>Table D-1:  Risk Level for All Assets</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan ="2">Asset Group</th>
                    <th colspan="3">Risk Level</th>
                </tr>
                <tr>
                    <th style="width: 15%;">Low</th>
                    <th style="width: 15%;">Medium</th>
                    <th style="width: 15%;">High</th>
                </tr>
            </thead>
            <tbody>
                    @php

                        // Define the custom order for the asset types
                        $customOrder = ['Hardware', 'Software', 'Data and Information', 'Human Resources', 'Services', 'Work Process', 'Premise'];

                        // Fetch the number of asset types per vulnerability group (type) and impact level
                        $riskLevels = DB::table('asset_threat')
                            ->join('asset_management', 'asset_threat.asset_id', '=', 'asset_management.id') // Join with asset_management
                            ->join('asset_rmsd', 'asset_threat.id', '=', 'asset_rmsd.threat_id') // Join with asset_rmsd
                            ->select('asset_management.type',
                                DB::raw('SUM(CASE WHEN asset_rmsd.risk_level = "Low" THEN 1 ELSE 0 END) as Low'),
                                DB::raw('SUM(CASE WHEN asset_rmsd.risk_level = "Medium" THEN 1 ELSE 0 END) as Medium'),
                                DB::raw('SUM(CASE WHEN asset_rmsd.risk_level = "High" THEN 1 ELSE 0 END) as High')
                            )
                            ->whereIn('asset_management.type', $customOrder) // Fetch only specified types
                            ->groupBy('asset_management.type') // Group by asset type (e.g., Hardware, Software)
                            ->get();

                        // Convert the fetched data into an associative array for easy access
                        $riskLevels = $riskLevels->keyBy('type');

                        // Ensure that all asset types are included, even if some don't have associated assets
                        foreach ($customOrder as $group) {
                            if (!isset($riskLevels[$group])) {
                                $riskLevels[$group] = (object) [
                                    'type' => $group,
                                    'Low' => 0,
                                    'Medium' => 0,
                                    'High' => 0
                                ];
                            }
                        }

                        // Reindex to maintain the correct order based on the $customOrder
                        $riskLevels = collect($riskLevels)->sortBy(function ($item) use ($customOrder) {
                            return array_search($item->type, $customOrder);
                        });
                    @endphp



                     @foreach($riskLevels as $riskLevel)
                        <tr>
                            <td>{{ $riskLevel->type }}</td>
                            <td>{{ $riskLevel->Low ?? 0 }}</td>
                            <td>{{ $riskLevel->Medium ?? 0 }}</td>
                            <td>{{ $riskLevel->High ?? 0 }}</td>
                        </tr>


                    @endforeach
        

                <tr class="total">
                    <td>Total</td>
                    <td>{{ $riskLevels->sum('Low')  }}</td>
                    <td>{{ $riskLevels->sum('Medium')}}</td>
                    <td>{{ $riskLevels->sum('High') }}</td>
                </tr>


            </tbody>
        </table>
    



    </div>
</body>
</html>


