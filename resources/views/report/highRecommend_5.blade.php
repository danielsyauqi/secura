<!DOCTYPE html>
<html>
<head>

    <title>High Level Recommendation Summary Report (Scale 5)</title>
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


    </style>


</head>
<body>

    <div style="page-break-after: always;">
        <h3 style="text-align:left; font-size:16px; margin-left: 10px;">SULIT</h3>


        <div style="text-align: center; margin-top: 100px">
            <img src="{{ file_exists(public_path('/favicon.ico')) ? public_path('/favicon.ico') : public_path('/default-logo.png') }}" alt="" style="width: 250px; height: auto;">
            @php
            // Fetch the record from the database
            $orgProfile = \App\Models\OrgProfile::find(1);
        @endphp
        
        <h1>{{ $orgProfile ? $orgProfile->name : 'No Name Found' }}</h1>
        <h2>High Level Recommendation Summary (Scale 5)</h2>
            <p>Date: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        </div>

    </div>


    <header>
        <div class="header">
            <img src="{{ file_exists(public_path('/favicon.ico')) ? public_path('/favicon.ico') : public_path('/default-logo.png') }}" alt="" style="width: 50px; height: auto;">
            <div class="header-1">
                @php
                // Fetch the record from the database
                $orgProfile = \App\Models\OrgProfile::find(1);
            @endphp
            
            <h1>{{ $orgProfile ? $orgProfile->name : 'No Name Found' }}</h1>
            <p>High Level Recommendation Summary Report (Scale 5)</p>
            </div>
        </div>
    </header>
    
    <h3 style="text-align:left; font-size: 11px;">SULIT</h3>

    <span class="pagenum">Page </span>

    

    <table>
            <thead>
                <tr>
                    <th rowspan ="2" style="width: 10%;">Asset Group</th>
                    <th rowspan ="2" style="width: 10%;">Num. of Assets</th>
                    <th colspan="5">Risk Level</th>
                    <th colspan="4">High Level Recommendation (Decision/Recommendation)</th>
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

                </tr>
            </thead>

            


            // Fetch the number of asset types per risk level
                @php
                        // Define the custom order for the asset types
                        $customOrder = ['Hardware', 'Software', 'Data and Information', 'Human Resources', 'Services', 'Work Process', 'Premise'];

                        // Fetch the number of asset types per rmsd group (type) and threat level
                        $riskLevels = DB::table('asset_threat')
                            ->join('asset_management', 'asset_threat.asset_id', '=', 'asset_management.id') // Join with asset_management
                            ->join('asset_rmsd', 'asset_threat.id', '=', 'asset_rmsd.threat_id') // Join with asset_rmsd
                            ->select('asset_management.type',
                                DB::raw('SUM(CASE WHEN asset_rmsd.risk_level_5 = "Low" THEN 1 ELSE 0 END) as Low'),
                                DB::raw('SUM(CASE WHEN asset_rmsd.risk_level_5 = "Medium" THEN 1 ELSE 0 END) as Medium'),
                                DB::raw('SUM(CASE WHEN asset_rmsd.risk_level_5 = "High" THEN 1 ELSE 0 END) as High'),
                                DB::raw('SUM(CASE WHEN asset_rmsd.risk_level_5 = "Very Low" THEN 1 ELSE 0 END) as VeryLow'),
                                DB::raw('SUM(CASE WHEN asset_rmsd.risk_level_5 = "Very High" THEN 1 ELSE 0 END) as VeryHigh'),
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
                            <td>{{ $assetCount }}</td>
                            <td>{{ $riskLevel->VeryLow ?? 0 }}</td>
                            <td>{{ $riskLevel->Low ?? 0 }}</td>
                            <td>{{ $riskLevel->Medium ?? 0 }}</td>
                            <td>{{ $riskLevel->High ?? 0 }}</td>
                            <td>{{ $riskLevel->VeryHigh ?? 0 }}</td>
                            <td>{{ $highRecommend[$riskLevel->type]->Accept ?? 0 }}</td>
                            <td>{{ $highRecommend[$riskLevel->type]->Reduce ?? 0 }}</td>
                            <td>{{ $highRecommend[$riskLevel->type]->Transfer ?? 0 }}</td>
                            <td>{{ $highRecommend[$riskLevel->type]->Avoid ?? 0 }}</td>

                
                            
                    </tr>
                    @endforeach


                    <tr style="background-color:#ffff97; font-weight: bold;">
                        <td>Total</td>
                        <td>{{ DB::table('asset_management')->count() }}</td>
                        <td>{{ $riskLevels->sum('VeryLow') }}</td>
                        <td>{{ $riskLevels->sum('Low') }}</td>
                        <td>{{ $riskLevels->sum('Medium') }}</td>
                        <td>{{ $riskLevels->sum('High') }}</td>
                        <td>{{ $riskLevels->sum('VeryHigh') }}</td>
                        <td>{{ $highRecommend->sum('Accept') }}</td>
                        <td>{{ $highRecommend->sum('Reduce') }}</td>
                        <td>{{ $highRecommend->sum('Transfer') }}</td>
                        <td>{{ $highRecommend->sum('Avoid') }}</td>
                    </tr>

            </tbody>
        </table>

</body>
</html>


