<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bureaux CHRONOREX EXPRESS</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f5f5f5; font-weight: 600; }
        h1 { font-size: 18px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>CHRONOREX EXPRESS — Liste des bureaux</h1>
    <table>
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Wilaya</th>
                <th>Commune</th>
                <th>Code</th>
                <th>Entreprise</th>
                <th>Téléphone</th>
                <th>Tél. 2</th>
                <th>Adresse</th>
                <th>Visible</th>
            </tr>
        </thead>
        <tbody>
            @foreach($offices as $office)
                <tr>
                    <td>{{ $office->display_order }}</td>
                    <td>{{ $office->wilaya->name }}</td>
                    <td>{{ $office->commune?->name ?? '-' }}</td>
                    <td>{{ $office->wilaya->code }}</td>
                    <td>{{ $office->company_name }}</td>
                    <td>{{ $office->phone }}</td>
                    <td>{{ $office->phone_secondary ?? '-' }}</td>
                    <td>{{ $office->address }}</td>
                    <td>{{ $office->is_visible ? 'Oui' : 'Non' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
