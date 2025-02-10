<!DOCTYPE html>
<html>
<head>
    <title>Detail Risk Assessment Report</title>
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

        /* Optional: Specific column widths for better readability */
        th:nth-child(1), td:nth-child(1) {
            width: 5%;
        }

        th:nth-child(2), td:nth-child(2) {
            width: 15%;
        }

        th:nth-child(3), td:nth-child(3) {
            width: 10%;
        }

        th:nth-child(4), td:nth-child(4) {
            width: 10%;
        }

        th:nth-child(5), td:nth-child(5) {
            width: 10%;
        }

        th:nth-child(6), td:nth-child(6) {
            width: 10%;
        }

        th:nth-child(7), td:nth-child(7) {
            width: 15%;
        }

        th:nth-child(8), td:nth-child(8) {
            width: 5%;
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
        <div style="text-align: center; margin-top: 100px">
            <img src="{{ file_exists(public_path('/favicon.ico')) ? public_path('/favicon.ico') : public_path('/default-logo.png') }}" alt="" style="width: 250px; height: auto;">
            @php
            // Fetch the record from the database
            $orgProfile = \App\Models\OrgProfile::find(1);
        @endphp
        
        <h1>{{ $orgProfile ? $orgProfile->name : 'No Name Found' }}</h1>
        <h2>Detail Risk Assessment</h2>
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
        <img src="{{ file_exists(public_path('/favicon.ico')) ? public_path('/favicon.ico') : public_path('/default-logo.png') }}" alt="" style="width: 50px; height: auto;">
        <div class="header-1">
            @php
            // Fetch the record from the database
            $orgProfile = \App\Models\OrgProfile::find(1);
        @endphp
        
        <h1>{{ $orgProfile ? $orgProfile->name : 'No Name Found' }}</h1>
        <p>Detail Risk Assessment Report</p>
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
        @php
            $counters = [];
        @endphp

        @foreach ($assetsByType as $index => $asset)
            @php
                $counters[$type] = $counters[$type] ?? 0;
                $counters[$type]++;
            @endphp

            @if ($asset->threats && $asset->threats->count() > 0)
                <tr>
                    <!-- Common asset data, displayed only once for each asset -->
                    <td>{{ $counters[$type] }}</td>
                    <td>{{ $asset->name ?? 'N/A' }}</td>
                    <td>{{ $asset->quantity ?? 'N/A' }}</td>
                    <td>{{ $asset->owner ?? 'N/A' }}</td>
                    <td>{{ $asset->custodian ?? 'N/A' }}</td>
                    <td>{{ $asset->location ?? 'N/A' }}</td>
                    <td>{{ $asset->description ?? 'N/A' }}</td>
                    <td>{{ $asset->confidential ?? 'N/A' }}</td>
                    <td>{{ $asset->integrity ?? 'N/A' }}</td>
                    <td>{{ $asset->availability ?? 'N/A' }}</td>
                    <td>{{ $asset->valuation->depend_on ?? 'N/A' }}</td>
                    <td>{{ $asset->valuation->depended_asset ?? 'N/A' }}</td>
                    <td>{{ $asset->valuation->asset_value ?? 'N/A' }}</td>



                    <!-- Threats in the same row -->
                    <td>
                        @foreach ($asset->threats as $threat)
                            @php
                                $rmsd = $threat->rmsd->first();
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
                            @endphp
                            <!-- Business Loss -->
                            <div>{{ $rmsd->business_loss  ?? 'N/A' }}</div>
                            <br>
                            @endforeach
                    </td>
                    
                    <td>
                        @foreach ($asset->threats as $threat)
                            @php
                                $rmsd = $threat->rmsd->first();
                            @endphp
                            <!-- Impact Level -->
                            <div>{{ $rmsd->impact_level ?? 'N/A' }}</div>
                            <br>
                            @endforeach
                    </td>
                    
                    <td>
                        @foreach ($asset->threats as $threat)
                            @php
                                $rmsd = $threat->rmsd->first();
                            @endphp
                            <!-- Likelihood -->
                            <div>{{ $rmsd->likelihood ?? 'N/A' }}</div>
                            <br>
                            @endforeach
                    </td>
                    
                    <td>
                        @foreach ($asset->threats as $threat)
                            @php
                                $rmsd = $threat->rmsd->first();
                            @endphp
                            <!-- Risk Level -->
                            <div>{{ $rmsd->risk_level ?? 'N/A' }}</div>
                            <br>
                            @endforeach
                    </td>
                    
                </tr>
                @else
                <tr>
                    <!-- Single threat (if no threats are found) -->
                    <td>{{ $counters[$type] }}</td>
                    <td>{{ $asset->name ?? 'N/A' }}</td>
                    <td>{{ $asset->quantity ?? 'N/A' }}</td>
                    <td>{{ $asset->owner ?? 'N/A' }}</td>
                    <td>{{ $asset->custodian ?? 'N/A' }}</td>
                    <td>{{ $asset->location ?? 'N/A' }}</td>
                    <td>{{ $asset->description ?? 'N/A' }}</td>
                    <td>{{ $asset->valuation->confidential_5 ?? 'N/A' }}</td>
                    <td>{{ $asset->valuation->integrity_5 ?? 'N/A' }}</td>
                    <td>{{ $asset->valuation->availability_5 ?? 'N/A' }}</td>
                    <td>{{ $asset->valuation->depend_on ?? 'N/A' }}</td>
                    <td>{{ $asset->valuation->depended_asset ?? 'N/A' }}</td>
                    <td>{{ $asset->valuation->asset_value_5 ?? 'N/A' }}</td>

                    @php
                    $threat = $asset->threats->first();
                    $rmsd = $threat ? $threat->rmsd->first() : null;
                    @endphp

                    <td>{{ $threat->threat_name ?? 'N/A' }}</td>
                    <td>{{ $rmsd->vuln_name ?? 'N/A' }}</td>
                    <td>{{ $rmsd->safeguard_id ?? 'N/A' }}</td>
                    <td>{{ $rmsd->business_loss_5?? 'N/A' }}</td>
                    <td>{{ $rmsd->impact_level_5?? 'N/A' }}</td>
                    <td>{{ $rmsd->likelihood_5 ?? 'N/A' }}</td>
                    <td>{{ $rmsd->risk_level_5 ?? 'N/A' }}</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    @endforeach
    <span class="pagenum">Page </span>
</body>
</html>
