<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Anggota</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "DejaVu Sans", sans-serif;
            color: #1e293b;
            font-size: 12px;
            padding: 24px;
        }
        h1 {
            font-size: 20px;
            color: #ff6d01;
            margin-bottom: 4px;
        }
        .subtitle {
            color: #64748b;
            font-size: 11px;
            margin-bottom: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead th {
            background-color: #ff6d01;
            color: #ffffff;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        tbody tr:nth-child(even) {
            background-color: #fff7ed;
        }
        .footer {
            margin-top: 16px;
            font-size: 10px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <h1>Daftar Anggota</h1>
    <p class="subtitle">Total {{ count($members) }} anggota</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Peran</th>
                <th>Status</th>
                <th>Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $m)
                <tr>
                    <td>{{ $m[0] }}</td>
                    <td>{{ $m[1] }}</td>
                    <td>{{ $m[2] }}</td>
                    <td>{{ $m[3] }}</td>
                    <td>{{ $m[4] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="footer">Dokumen ini dibuat otomatis oleh sistem.</p>
</body>
</html>
