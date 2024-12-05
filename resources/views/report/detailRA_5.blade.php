<!DOCTYPE html>
<html>
<head>
    <title>Detail Risk Assessment Report (Scale 5)</title>
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
            font-size: 7px; /* Adjusted font size for better readability */
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

        threat-info {
            padding-bottom: 10px; /* Add vertical spacing between threats */
        }

        threat-info hr {
            border-top: 1px solid #ccc; /* Adds a horizontal line between threats */
            margin-top: 5px;
            margin-bottom: 5px;
        }



    </style>
</head>
<body>
        <h3 style="text-align:left; font-size:16px; margin-left: 10px;">SULIT</h3>
        <div style="text-align: center; margin-top: 100px">
            <img src="{{ public_path('/default-logo.png') }}" alt="Malaysian Nuclear Agency Logo" style="width: 250px; height: auto;">
            <h1>Malaysian Nuclear Agency</h1>
            <h2>Detail Risk Assessment (Scale 5)</h2>
            <p>Date: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        </div>

    

    @php
        $groupedAssets = [
            'Hardware' => $assets->where('type', 'Hardware'),
            'Software' => $assets->where('type', 'Software'),
            'Data and Information' => $assets->where('type', 'Data and Information'),
            'Human Resources' => $assets->where('type', 'Human Resources'),
            'Services' => $assets->where('type', 'Services'),
            'Work Process' => $assets->where('type', 'Work Process'),
            'Premise' => $assets->where('type', 'Premise')
        ]; // Group assets by type
    @endphp
    

                    @foreach ($groupedAssets as $type => $assetsByType)
                        <div class="page-break"></div>

                        <header>
                            <div class="header">
                                <img src="{{ public_path('/default-logo.png') }}" alt="">
                                <div class="header-1">
                                    <h1>Malaysian Nuclear Agency</h1>
                                    <p>Detail Risk Assessment Report (Scale 5)</p>
                                </div>
                            </div>
                        </header>

                        <h3 style="text-align:left; font-size: 11px;">SULIT</h3>
                        <h2 style="font-size: 15px; text-align:center">{{ $type }}</h2>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Asset Name</th>
                                    <th>Qty.</th>
                                    <th>Owner</th>
                                    <th>Custodian</th>
                                    <th>Location</th>
                                    <th>Description</th>
                                    <th>C</th>
                                    <th>I</th>
                                    <th>A</th>
                                    <th>Asset Dependent On</th>
                                    <th>Dependent Asset</th>
                                    <th>Asset Value</th>
                                    <th>Threat</th>
                                    <th>Vulnerability</th>
                                    <th>Safeguards</th>
                                    <th>Business Loss</th>
                                    <th>Impact Level</th>
                                    <th>Likelihood</th>
                                    <th>Risk Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assetsByType as $index => $asset)
                    @if ($asset->threats && $asset->threats->count() > 0)
                    
                    @php
                        $valuation = $asset->valuation->first();
                        $scale_5_valuation = $valuation && $valuation->scale_5 ? json_decode($valuation->scale_5, true) : [];
                        

                    @endphp
                        <tr>
                            <!-- Common asset data, displayed only once for each asset -->
                            <td>{{ $loop->parent->iteration }}</td>
                            <td>{{ $asset->name ?? 'N/A' }}</td>
                            <td>{{ $asset->quantity ?? 'N/A' }}</td>
                            <td>{{ $asset->owner ?? 'N/A' }}</td>
                            <td>{{ $asset->custodian ?? 'N/A' }}</td>
                            <td>{{ $asset->location ?? 'N/A' }}</td>
                            <td>{{ $asset->description ?? 'N/A' }}</td>
                            <td>{{ $scale_5_valuation['confidential'] ?? 'N/A' }}</td>
                            <td>{{ $scale_5_valuation['integrity'] ?? 'N/A' }}</td>
                            <td>{{ $scale_5_valuation['availability'] ?? 'N/A' }}</td>
                            <td>{{ $asset->valuation->depend_on ?? 'N/A' }}</td>
                            <td>{{ $asset->valuation->depended_asset ?? 'N/A' }}</td>
                            <td>{{ $scale_5_valuation['asset_value'] ?? 'N/A' }}</td>

                            <!-- Threats in the same row -->
                            <td>
                                @foreach ($asset->threats as $threat)
                                    @php
                                        $rmsd = $threat->rmsd->first();
                                        $scale_5_rmsd = $rmsd && $rmsd->scale_5 ? json_decode($rmsd->scale_5, true) : [];
                                    @endphp
                                    <!-- Threat Name -->
                                    <div>{{ $threat->threat_name ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                            </td>
                            
                            <td>
                                @foreach ($asset->threats as $threat)
                                    @php
                                        $rmsd = $threat->rmsd->first();
                                    @endphp
                                    <!-- Vulnerability Name -->
                                    <div>{{ $rmsd->vuln_name ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                            </td>
                            
                            <td>
                                @foreach ($asset->threats as $threat)
                                    @php
                                        $rmsd = $threat->rmsd->first();
                                    @endphp
                                    <!-- Safeguard ID -->
                                    <div>{{ $rmsd->safeguard_id ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                            </td>
                            
                            <td>
                                @foreach ($asset->threats as $threat)
                                    @php
                                        $rmsd = $threat->rmsd->first();
                                        $scale_5_rmsd = $rmsd && $rmsd->scale_5 ? json_decode($rmsd->scale_5, true) : [];
                                    @endphp
                                    <!-- Business Loss -->
                                    <div>{{ $scale_5_rmsd['business_loss'] ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                            </td>
                            
                            <td>
                                @foreach ($asset->threats as $threat)
                                    @php
                                        $rmsd = $threat->rmsd->first();
                                        $scale_5_rmsd = $rmsd && $rmsd->scale_5 ? json_decode($rmsd->scale_5, true) : [];
                                    @endphp
                                    <!-- Impact Level -->
                                    <div>{{ $scale_5_rmsd['impact_level'] ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                            </td>
                            
                            <td>
                                @foreach ($asset->threats as $threat)
                                    @php
                                        $rmsd = $threat->rmsd->first();
                                        $scale_5_rmsd = $rmsd && $rmsd->scale_5 ? json_decode($rmsd->scale_5, true) : [];
                                    @endphp
                                    <!-- Likelihood -->
                                    <div>{{ $scale_5_rmsd['likelihood'] ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                            </td>
                            
                            <td>
                                @foreach ($asset->threats as $threat)
                                    @php
                                        $rmsd = $threat->rmsd->first();
                                        $scale_5_rmsd = $rmsd && $rmsd->scale_5 ? json_decode($rmsd->scale_5, true) : [];
                                    @endphp
                                    <!-- Risk Level -->
                                    <div>{{ $scale_5_rmsd['risk_level'] ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                            </td>
                            
                        </tr>
                    @else

                        <tr>
                            
                            <!-- Single threat (if no threats are found) -->
                            <td>{{ $loop->parent->iteration }}</td>
                            <td>{{ $asset->name ?? 'N/A' }}</td>
                            <td>{{ $asset->quantity ?? 'N/A' }}</td>
                            <td>{{ $asset->owner ?? 'N/A' }}</td>
                            <td>{{ $asset->custodian ?? 'N/A' }}</td>
                            <td>{{ $asset->location ?? 'N/A' }}</td>
                            <td>{{ $asset->description ?? 'N/A' }}</td>
                            <td>{{ $scale_5_valuation['confidential'] ?? 'N/A' }}</td>
                            <td>{{ $scale_5_valuation['integrity'] ?? 'N/A' }}</td>
                            <td>{{ $scale_5_valuation['availability'] ?? 'N/A' }}</td>
                            <td>{{ $asset->valuation->depend_on ?? 'N/A' }}</td>
                            <td>{{ $asset->valuation->depended_asset ?? 'N/A' }}</td>
                            <td>{{ $scale_5_valuation['asset_value'] ?? 'N/A' }}</td>

                            @php
                                $threat = $asset->threats->first();
                                $rmsd = $threat ? $threat->rmsd->first() : null;
                                $scale_5_rmsd = $rmsd && $rmsd->scale_5 ? json_decode($rmsd->scale_5, true) : [];
                            @endphp

                            <td>{{ $threat->threat_name ?? 'N/A' }}</td>
                            <td>{{ $rmsd->vuln_name ?? 'N/A' }}</td>
                            <td>{{ $rmsd->safeguard_id ?? 'N/A' }}</td>
                            <td>{{ $scale_5_rmsd['business_loss'] ?? 'N/A' }}</td>
                            <td>{{ $scale_5_rmsd['impact_level'] ?? 'N/A' }}</td>
                            <td>{{ $scale_5_rmsd['likelihood'] ?? 'N/A' }}</td>
                            <td>{{ $scale_5_rmsd['risk_level'] ?? 'N/A' }}</td>
                        </tr>
                    @endif
                @endforeach


            </tbody>
        </table>

    @endforeach
    <span class="pagenum">Page </span>
</body>
</html>
