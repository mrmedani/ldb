<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $settings->site_name ?? 'Chronorex Express' }} — Liste des bureaux</title>
    <style>
        @page {
            margin: 110px 40px 60px 40px;
        }
        
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #1f2937; /* Gray 800 */
            line-height: 1.4;
        }
        
        /* Header styling repeating on every page */
        header {
            position: fixed;
            top: -90px;
            left: 0;
            right: 0;
            height: 75px;
            border-bottom: 2px solid #4f46e5; /* Primary brand color */
            padding-bottom: 10px;
        }
        
        .header-logo-container {
            float: left;
            width: 40%;
        }
        
        .header-logo {
            height: 35px;
            max-width: 150px;
        }
        
        .header-text-container {
            float: right;
            width: 60%;
            text-align: right;
        }
        
        .header-title {
            font-size: 16px;
            font-weight: 800;
            color: #4f46e5;
            margin: 0 0 2px 0;
            letter-spacing: -0.5px;
        }
        
        .header-subtitle {
            font-size: 9px;
            color: #6b7280; /* Gray 500 */
            margin: 0;
        }
        
        /* Footer styling repeating on every page */
        footer {
            position: fixed;
            bottom: -45px;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            font-size: 8px;
            color: #9ca3af; /* Gray 400 */
            border-top: 1px solid #e5e7eb;
            padding-top: 5px;
        }
        
        .footer-page:after {
            content: counter(page);
        }
        
        /* Main content layout */
        .info-bar {
            margin-top: 0px;
            margin-bottom: 15px;
            padding: 8px 12px;
            background-color: #f3f4f6; /* Gray 100 */
            border-radius: 6px;
            font-size: 9px;
        }
        
        .info-bar-left {
            float: left;
            width: 50%;
            font-weight: bold;
            color: #374151;
        }
        
        .info-bar-right {
            float: right;
            width: 50%;
            text-align: right;
            color: #6b7280;
        }
        
        .clear {
            clear: both;
        }
        
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: auto;
        }
        
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        th {
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8px;
            letter-spacing: 0.5px;
            padding: 7px 8px;
            text-align: left;
            border-bottom: 2px solid #3730a3;
        }
        
        td {
            padding: 7px 8px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
            vertical-align: middle;
        }
        
        tr:nth-child(even) td {
            background-color: #fafafa;
        }
        
        /* Badges & typography helper classes */
        .badge-delivery {
            display: inline-block;
            background-color: #d1fae5; /* Emerald 100 */
            color: #065f46; /* Emerald 800 */
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 8px;
        }
        
        .badge-code {
            font-family: monospace;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 1px 4px;
            border-radius: 3px;
            color: #4b5563;
        }
        
        .text-bold {
            font-weight: bold;
            color: #111827;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .phone-link {
            color: #1f2937;
            text-decoration: none;
            font-weight: 500;
        }
        
        .address-text {
            color: #4b5563;
            max-width: 250px;
        }
        
        .company-logo-placeholder {
            width: 24px;
            height: 24px;
            line-height: 24px;
            text-align: center;
            background-color: #eef2ff;
            color: #4f46e5;
            font-weight: bold;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-logo-container">
            @if ($logoBase64)
                <img src="{{ $logoBase64 }}" class="header-logo" alt="Logo">
            @else
                <div style="font-size: 20px; font-weight: 800; color: #4f46e5; line-height: 35px;">
                    {{ substr($settings->site_name ?? 'CR', 0, 2) }}<span style="color: #111827;">{{ substr($settings->site_name ?? 'Chronorex', 2) }}</span>
                </div>
            @endif
        </div>
        <div class="header-text-container">
            <h1 class="header-title">{{ $settings->site_name ?? 'Chronorex Express' }}</h1>
            <p class="header-subtitle">{{ $settings->footer_tagline ?? 'Livraison express dans toute l\'Algérie' }}</p>
        </div>
        <div class="clear"></div>
    </header>

    <!-- Footer -->
    <footer>
        <div style="float: left; width: 60%; text-align: left;">
            {{ str_replace('{year}', date('Y'), $settings->footer_copyright ?? '© {year} CHRONOREX EXPRESS. Tous droits réservés.') }}
        </div>
        <div style="float: right; width: 40%; text-align: right;" class="footer-page">
            Page &nbsp;
        </div>
        <div class="clear"></div>
    </footer>

    <!-- Info/Meta Bar -->
    <div class="info-bar">
        <div class="info-bar-left">
            Liste des Bureaux Partenaires
            @if ($search)
                <span style="font-weight: normal; color: #6b7280; font-style: italic;">
                    (Filtré par: "{{ $search }}")
                </span>
            @endif
        </div>
        <div class="info-bar-right">
            Généré le {{ date('d/m/Y à H:i') }} | {{ $offices->count() }} bureau(x) trouvé(s)
        </div>
        <div class="clear"></div>
    </div>

    <!-- Offices Table -->
    <table>
        <thead>
            <tr>
                @foreach ($settings->ordered_columns as $col)
                    <th @if($col['key'] === 'maps') class="text-center" @endif>
                        {{ $col['label'] }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($offices as $office)
                <tr>
                    @foreach ($settings->ordered_columns as $col)
                        @switch($col['key'])
                            @case('wilaya')
                                <td>
                                    <span class="text-bold">{{ $office->wilaya->name }}</span>
                                </td>
                                @break
                                
                            @case('commune')
                                <td>
                                    <span>{{ $office->commune?->name ?? '-' }}</span>
                                </td>
                                @break
                                
                            @case('delivery_time')
                                <td>
                                    @if ($office->wilaya->delivery_time)
                                        <span class="badge-delivery">{{ $office->wilaya->delivery_time }}</span>
                                    @else
                                        <span style="color: #d1d5db;">—</span>
                                    @endif
                                </td>
                                @break
                                
                            @case('code')
                                <td>
                                    <span class="badge-code">{{ $office->wilaya->code }}</span>
                                </td>
                                @break
                                
                            @case('company')
                                <td>
                                    <table style="width: auto; border: none; margin: 0; padding: 0; background: transparent;">
                                        <tr>
                                            <td style="border: none; padding: 0 6px 0 0; vertical-align: middle; background: transparent;">
                                                <span class="company-logo-placeholder" style="margin: 0; display: block;">{{ substr($office->company_name, 0, 1) }}</span>
                                            </td>
                                            <td style="border: none; padding: 0; vertical-align: middle; font-weight: bold; white-space: nowrap; background: transparent;">
                                                <span class="text-bold" style="display: block;">{{ $office->company_name }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                @break
                                
                            @case('phone')
                                <td>
                                    <span class="phone-link">{{ $office->phone }}</span>
                                    @if ($office->phone_secondary)
                                        <br><span class="phone-link" style="color: #6b7280; font-size: 9px;">{{ $office->phone_secondary }}</span>
                                    @endif
                                </td>
                                @break
                                
                            @case('address')
                                <td>
                                    <div class="address-text">{{ $office->address }}</div>
                                </td>
                                @break
                                
                            @case('maps')
                                <td class="text-center">
                                    @if ($office->google_maps)
                                        <a href="{{ $office->google_maps }}" target="_blank" style="color: #4f46e5; font-weight: bold; text-decoration: none;">Oui</a>
                                    @else
                                        <span style="color: #d1d5db;">—</span>
                                    @endif
                                </td>
                                @break
                        @endswitch
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($settings->ordered_columns) }}" style="text-align: center; padding: 30px; color: #9ca3af;">
                        Aucun bureau trouvé.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
