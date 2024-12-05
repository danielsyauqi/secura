<!DOCTYPE html>
<html>
<head>
    <title>Risk Treatment Plan Summary Report (Scale 5)</title>
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
            margin-bottom: 20px; /* Add space between tables */

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
        header {
            position: fixed;
            left: 0px;
            right: 0px;
            height: 150px;
            margin-top: -50px;
        }

        .page-break {
            page-break-before: always;
        }

        
    </style>
</head>
<body>
    <h3 style="text-align:left; font-size:16px; margin-left: 10px;">SULIT</h3>
    <div style="text-align: center; margin-top: 100px;" class="main-page">
        <img src="{{ public_path('/default-logo.png') }}" alt="Malaysian Nuclear Agency Logo" style="width: 250px; height: auto;">
        <h1>Malaysian Nuclear Agency</h1>
        <h2>Risk Treatment Plan Summary Report (Scale 5)</h2>
        <p>Date: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
    </div>




    <!-- Loop through each safeguard group -->
    @foreach($safeguardOptions as $group => $options)

    <div class="page-break">
        <header>
            <div class="header">
                <img src="{{ public_path('/default-logo.png') }}" alt="">
                <div class="header-1">
                    <h1>Malaysian Nuclear Agency</h1>
                    <p>Risk Treatment Summary Report (Scale 5)</p>
                </div>
            </div>
        </header>

        <span class="pagenum">Page </span>

        <h3 style="text-align:left; font-size: 11px;">SULIT</h3>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Protection ID</th>
                    <th colspan="7">Asset Type</th>
                    <th rowspan="2" style="width: 10%">Total</th>
                </tr>
                <tr>
                    <th style="width: 8%">Hardware</th>
                    <th style="width: 8%">Software</th>
                    <th style="width: 8%">Data and Information</th>
                    <th style="width: 8%">Human Resources</th>
                    <th style="width: 8%">Services</th>
                    <th style="width: 8%">Work Process</th>
                    <th style="width: 8%">Premise</th>
                </tr>
            </thead>
            <tbody>


                <!-- Section Heading (Safeguard Group) -->
                <tr class="header">
                    <td colspan="9" style="font-size: 12px; background-color: #eaf0fb;">
                        {{ $group }}
                    </td>
                </tr>


                @php
                // Fetch the number of asset types per threat group (vulnerability group)
                $treatment = DB::table('asset_threat')
                    ->join('asset_management', 'asset_threat.asset_id', '=', 'asset_management.id') // Join asset_threat with asset_management
                    ->join('asset_protection', 'asset_threat.id', '=', 'asset_protection.threat_id') // Join asset_threat with asset_protection
                    ->select('asset_protection.protection_id',
                        DB::raw('SUM(CASE WHEN asset_management.type = "Hardware" THEN 1 ELSE 0 END) as Hardware'),
                        DB::raw('SUM(CASE WHEN asset_management.type = "Software" THEN 1 ELSE 0 END) as Software'),
                        DB::raw('SUM(CASE WHEN asset_management.type = "Data and Information" THEN 1 ELSE 0 END) as DataAndInformation'),
                        DB::raw('SUM(CASE WHEN asset_management.type = "Human Resources" THEN 1 ELSE 0 END) as HumanResources'),
                        DB::raw('SUM(CASE WHEN asset_management.type = "Services" THEN 1 ELSE 0 END) as Services'),
                        DB::raw('SUM(CASE WHEN asset_management.type = "Work Process" THEN 1 ELSE 0 END) as WorkProcess'),
                        DB::raw('SUM(CASE WHEN asset_management.type = "Premise" THEN 1 ELSE 0 END) as Premise')
                    )
                    ->whereIn('asset_protection.protection_id', $options) // Filter by the current protection group
                    ->groupBy('asset_protection.protection_id') // Group by vulnerability type
                    ->get();

                    $treatment = $treatment->keyBy('protection_id');

                        // Add missing groups with zero values if they don't exist in the data
                        foreach ($options as $group) {
                            if (!isset($treatment[$group])) {
                                $treatment[$group] = (object) [
                                    'protection_id' => $group,
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

                        $treatment = $treatment->sortKeys();

                @endphp

                <!-- Loop through the safeguard options for the current group -->
                @foreach($treatment as $protectionID)
                
                    <tr>
                        <td>{{ $protectionID->protection_id }}</td>
                        <!-- You can add columns for other asset types like Hardware, Software, etc. -->
                        <td> {{ $protectionID->Hardware ?? 0 }} </td>
                        <td> {{ $protectionID->Software ?? 0 }} </td>
                        <td> {{ $protectionID->DataAndInformation ?? 0 }} </td>
                        <td> {{ $protectionID->HumanResources ?? 0 }} </td>
                        <td> {{ $protectionID->Services ?? 0 }} </td>
                        <td> {{ $protectionID->WorkProcess ?? 0 }} </td>
                        <td> {{ $protectionID->Premise ?? 0 }} </td>
                        <td>
                            @php
                                $totalAssets = ($protectionID->Hardware ?? 0) 
                                            + ($protectionID->Software ?? 0) 
                                            + ($protectionID->DataAndInformation ?? 0) 
                                            + ($protectionID->HumanResources ?? 0) 
                                            + ($protectionID->Services ?? 0) 
                                            + ($protectionID->WorkProcess ?? 0) 
                                            + ($protectionID->Premise ?? 0);
                            @endphp
                            {{ $totalAssets }}
                        </td>        

                    </tr>
                @endforeach
            </tbody>
        </table>

        
        <span class="pagenum">Page </span>

    @endforeach


    <div class= "page-break"></div>
    <span class="pagenum">Page </span>

    <header>
        <div class="header">
            <img src="{{ public_path('/default-logo.png') }}" alt="">
            <div class="header-1">
                <h1>Malaysian Nuclear Agency</h1>
                <p>Risk Treatment Summary Report (Scale 5)</p>
            </div>
        </div>
    </header>


    <table>
        <thead>
            <tr>
                <th rowspan ="2" style="width: 10%;">Asset Group</th>
                <th rowspan ="2" style="width: 5%;">Num. of Assets</th>
                <th colspan="5">Risk Level</th>
                <th colspan="4">High Level Recommendation (Decision/Recommendation)</th>
                <th colspan="2">Risk Treatment</th>

            </tr>
            <tr>
                <th style="width: 5%;">Very High</th>
                <th style="width: 5%;">High</th>
                <th style="width: 5%;">Medium</th>
                <th style="width: 5%;">Low</th>
                <th style="width: 5%;">Very Low</th>
                <th style="width: 5%;">Accept</th>
                <th style="width: 5%;">Reduce</th>
                <th style="width: 5%;">Transfer</th>
                <th style="width: 5%;">Avoid</th>
                <th style="width: 5%;">Yes</th>
                <th style="width: 5%;">No</th>


            </tr>
        </thead>

        


        // Fetch the number of asset types per risk level
            @php
                    // Define the custom order for the asset types
                    $customOrder = ['Hardware', 'Software', 'Data and Information', 'Human Resources', 'Services', 'Work Process', 'Premise'];

                    // Fetch the number of asset types per rmsd group (type) and threat level
                    // Fetch the number of asset types per rmsd group (type) and threat level
                    $riskLevels = DB::table('asset_threat')
                            ->join('asset_management', 'asset_threat.asset_id', '=', 'asset_management.id') // Join with asset_management
                            ->join('asset_rmsd', 'asset_threat.id', '=', 'asset_rmsd.threat_id') // Join with asset_rmsd
                            ->select('asset_management.type',
                                // Extracting values from the scale_5 JSON column
                                DB::raw('SUM(CASE WHEN JSON_EXTRACT(asset_rmsd.scale_5, "$.risk_level") = "Low" THEN 1 ELSE 0 END) as Low'),
                                DB::raw('SUM(CASE WHEN JSON_EXTRACT(asset_rmsd.scale_5, "$.risk_level") = "Medium" THEN 1 ELSE 0 END) as Medium'),
                                DB::raw('SUM(CASE WHEN JSON_EXTRACT(asset_rmsd.scale_5, "$.risk_level") = "High" THEN 1 ELSE 0 END) as High'),
                                DB::raw('SUM(CASE WHEN JSON_EXTRACT(asset_rmsd.scale_5, "$.risk_level") = "Very Low" THEN 1 ELSE 0 END) as VeryLow'),
                                DB::raw('SUM(CASE WHEN JSON_EXTRACT(asset_rmsd.scale_5, "$.risk_level") = "Very High" THEN 1 ELSE 0 END) as VeryHigh'),
                                DB::raw('COUNT(*) as count')
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
                                'VeryLow' => 0,
                                'Low' => 0,
                                'Medium' => 0,
                                'High' => 0,
                                'VeryHigh' => 0,
                            ];
                        }
                    }

                    // Reindex to maintain the correct order based on the $customOrder
                    $riskLevels = collect($riskLevels)->sortBy(function ($item) use ($customOrder) {
                        return array_search($item->type, $customOrder);
                    });


                    // Define the custom order for the asset types
                    $customOrder = ['Hardware', 'Software', 'Data and Information', 'Human Resources', 'Services', 'Work Process', 'Premise'];

                    // Fetch the number of asset types per rmsd group (type) and threat level
                    $highRecommend = DB::table('asset_threat')
                        ->join('asset_management', 'asset_threat.asset_id', '=', 'asset_management.id') // Join with asset_management
                        ->join('asset_protection', 'asset_threat.id', '=', 'asset_protection.threat_id') // Join with asset_rmsd
                        ->select('asset_management.type',
                            DB::raw('SUM(CASE WHEN asset_protection.decision = "Accept" THEN 1 ELSE 0 END) as Accept'),
                            DB::raw('SUM(CASE WHEN asset_protection.decision = "Reduce" THEN 1 ELSE 0 END) as Reduce'),
                            DB::raw('SUM(CASE WHEN asset_protection.decision = "Transfer" THEN 1 ELSE 0 END) as Transfer'),
                            DB::raw('SUM(CASE WHEN asset_protection.decision = "Avoid" THEN 1 ELSE 0 END) as Avoid'),

                        )
                        ->whereIn('asset_management.type', $customOrder) // Fetch only specified types
                        ->groupBy('asset_management.type') // Group by asset type (e.g., Hardware, Software)
                        ->get();

                    // Convert the fetched data into an associative array for easy access
                    $highRecommend = $highRecommend->keyBy('type');

                    // Ensure that all asset types are included, even if some don't have associated assets
                    foreach ($customOrder as $group) {
                        if (!isset($highRecommend[$group])) {
                            $highRecommend[$group] = (object) [
                                'Accept' => 0,
                                'Reduce' => 0,
                                'Transfer' => 0,
                                'Avoid' => 0
                            ];
                        }
                    }





                @endphp


                @foreach($riskLevels as $riskLevel)
                <tr>
                    @php
                        $assetCount = DB::table('asset_management')
                            ->where('type', $riskLevel->type)
                            ->count();
                    @endphp
                        <td>{{ $riskLevel->type }}</td>
                        <td>{{ $riskLevel->VeryLow + $riskLevel->Low + $riskLevel->Medium + $riskLevel->High + $riskLevel->VeryHigh }} / {{ $assetCount }}</td>
                        <td>{{ $riskLevel->VeryLow ?? 0 }}</td>
                        <td>{{ $riskLevel->Low ?? 0 }}</td>
                        <td>{{ $riskLevel->Medium ?? 0 }}</td>
                        <td>{{ $riskLevel->High ?? 0 }}</td>
                        <td>{{ $riskLevel->VeryHigh ?? 0 }}</td>
                        <td>{{ $highRecommend[$riskLevel->type]->Accept ?? 0 }}</td>
                        <td>{{ $highRecommend[$riskLevel->type]->Reduce ?? 0 }}</td>
                        <td>{{ $highRecommend[$riskLevel->type]->Transfer ?? 0 }}</td>
                        <td>{{ $highRecommend[$riskLevel->type]->Avoid ?? 0 }}</td>
                        <td>{{ $highRecommend[$riskLevel->type]->Reduce ?? 0 }}</td>
                        <td>{{ $highRecommend[$riskLevel->type]->Accept ?? 0 }}</td>


                        
                </tr>
                @endforeach

                <tr style="background-color:#ffff97; font-weight: bold;">
                    <td>Total</td>
                    <td>{{ $riskLevels->sum(function($riskLevel) { return $riskLevel->VeryLow + $riskLevel->Low + $riskLevel->Medium + $riskLevel->High + $riskLevel->VeryHigh; }) }} / {{ DB::table('asset_management')->count() }}</td>
                    <td>{{ $riskLevels->sum('VeryLow') }}</td>
                    <td>{{ $riskLevels->sum('Low') }}</td>
                    <td>{{ $riskLevels->sum('Medium') }}</td>
                    <td>{{ $riskLevels->sum('High') }}</td>
                    <td>{{ $riskLevels->sum('VeryHigh') }}</td>
                    <td>{{ $highRecommend->sum('Accept') }}</td>
                    <td>{{ $highRecommend->sum('Reduce') }}</td>
                    <td>{{ $highRecommend->sum('Transfer') }}</td>
                    <td>{{ $highRecommend->sum('Avoid') }}</td>
                    <td>{{ $highRecommend->sum('Reduce') }}</td>
                    <td>{{ $highRecommend->sum('Accept') }}</td>
                </tr>

            </tbody>
        </table>
    </div>


</body>


</html>


