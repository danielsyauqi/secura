<!DOCTYPE html>
<html>
<head>
    <title>Risk Treatment Plan Appendix</title>
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
            font-size: 8px; /* Adjusted font size for better readability */
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
        <div style="text-align: center; margin-top: 100px" class="main-page">
            <img src="{{ public_path('/default-logo.png') }}" alt="Malaysian Nuclear Agency Logo" style="width: 250px; height: auto;">
            <h1>Malaysian Nuclear Agency</h1>
            <h2>Risk Treatment Plan Appendix </h2>
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
                        <p>Risk Treatment Plan Appendix</p>
                    </div>
                </div>
            </header>



            <h3 style="text-align:left; font-size: 11px;">SULIT</h3>
            <h2 style="font-size: 15px; text-align:center">{{ $type }}</h2>
            </div>
        <table>
            <thead>
                <tr>
                    <th rowspan = "2" style = "width: 5%">No.</th>
                    <th rowspan = "2" style = "width: 10%">Asset Name</th>
                    <th rowspan = "2" style = "width: 15%">Description</th>
                    <th rowspan = "2" style = "width: 5%">Qty.</th>
                    <th rowspan = "2" style = "width: 10%">Threat</th>
                    <th rowspan = "2" style = "width: 10%">Existing Safeguard</th>
                    <th rowspan = "2" style = "width: 10%">Risk Level</th>
                    <th rowspan = "2" style = "width: 10%">Action</th>
                    <th rowspan = "2" style = "width: 10%">Protection</th>
                    <th rowspan = "2" style = "width: 10%">Personnel</th>
                    <th colspan = "2" style = "width: 10%">Timeline</th>
                    <th rowspan = "2" style = "width: 10%">Residual Risk</th>
                </tr>
                <tr>
                    <th style = "width: 10%">Start Date</th>
                    <th style = "width: 10%">End Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assetsByType as $index => $asset)
                    @if ($asset->threats && $asset->threats->count() > 0)
                    <tr>
                        <td>{{ $loop->parent->iteration }}</td>
                        <td>{{ $asset->name ?? 'N/A' }}</td>
                        <td>{{ $asset->description ?? 'N/A' }}</td>
                        <td>{{ $asset->quantity ?? 'N/A' }}</td>
                      
                                <td>
                                    @foreach ($asset->threats as $threat)
                                    @php
                                         $rmsd = $threat->rmsd->first();
                                    @endphp
                                    
                                    <div>{{ $threat->threat_name ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                                
                                </td>

                                <td>
                                    @foreach ($asset->threats as $threat)
                                    @php
                                         $rmsd = $threat->rmsd->first();
                                    @endphp
                                    
                                    <div>{{ $rmsd->safeguard_id ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                                
                                </td>

                                <td>
                                    @foreach ($asset->threats as $threat)
                                    @php
                                         $rmsd = $threat->rmsd->first();
                                    @endphp
                                    
                                    <div>{{ $rmsd->risk_level ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                                
                                </td>

                                <td>
                                    @foreach ($asset->threats as $threat)
                                    @php
                                         $protection = $threat->protection->first();
                                    @endphp
                                    
                                    <div>{{ $protection->decision ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                                
                                </td>

                                <td>
                                    @foreach ($asset->threats as $threat)
                                    @php
                                         $protection = $threat->protection->first();
                                    @endphp
                                    
                                    <div>{{ $protection->protection_id ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                                
                                </td>

                                <td>
                                    @foreach ($asset->threats as $threat)
                                    @php
                                         $treatment = $threat->treatment->first();
                                    @endphp
                                    
                                    <div>{{ $treatment->personnel ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                                
                                </td>

                                <td>
                                    @foreach ($asset->threats as $threat)
                                    @php
                                         $treatment = $threat->treatment->first();
                                    @endphp
                                    
                                    <div>{{ $treatment->start_date ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                                
                                </td>

                                <td>
                                    @foreach ($asset->threats as $threat)
                                    @php
                                         $treatment = $threat->treatment->first();
                                    @endphp
                                    
                                    <div>{{ $treatment->end_date ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                                
                                </td>

                                <td>
                                    @foreach ($asset->threats as $threat)
                                    @php
                                         $treatment = $threat->treatment->first();
                                    @endphp
                                    
                                    <div>{{ $treatment->residual_risk ?? 'N/A' }}</div>
                                    <br>
                                    @endforeach
                                
                                </td>

                            </tr>
                        @else
                        <tr>
                            <td>{{ $loop->parent->iteration }}</td>
                            <td>{{ $asset->name ?? 'N/A' }}</td>
                            <td>{{ $asset->description ?? 'N/A' }}</td>
                            <td>{{ $asset->quantity ?? 'N/A' }}</td>
                            <td colspan="9">No threats available</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    @endforeach
    <span class="pagenum">Page </span>


</body>
</html>
