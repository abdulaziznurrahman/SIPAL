<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman SIPAL</title>
    <style>
        * { font-family: 'DejaVu Sans', sans-serif; }
        body { font-size: 11px; color: #1e293b; }

        .header { text-align: center; border-bottom: 2px solid #1e293b; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; letter-spacing: 1px; color: #1e293b; }
        .header p { margin: 4px 0 0 0; font-size: 11px; color: #64748b; }

        .meta { margin-bottom: 15px; font-size: 10px; color: #475569; }
        .meta table { width: 100%; }
        .meta td { padding: 2px 0; }

        table.data { width: 100%; border-collapse: collapse; }
        table.data th {
            background: #1e293b;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #1e293b;
        }
        table.data td {
            padding: 6px;
            border: 1px solid #cbd5e1;
            font-size: 10px;
            vertical-align: top;
        }
        table.data tr:nth-child(even) td { background: #f8fafc; }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        .badge-returned { background: #dbeafe; color: #1e40af; }

        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #64748b; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SIPAL</h1>
        <p>Sistem Peminjaman Alat Lab Komputer</p>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td><strong>Laporan:</strong> Data Peminjaman Alat</td>
                <td style="text-align: right;"><strong>Dicetak:</strong> {{ $generatedAt }}</td>
            </tr>
            <tr>
                <td><strong>Filter Status:</strong> {{ $filterStatus }}</td>
                <td style="text-align: right;"><strong>Total Data:</strong> {{ $borrowings->count() }} peminjaman</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 90px;">Kode</th>
                <th style="width: 100px;">Peminjam</th>
                <th style="width: 70px;">Kelas</th>
                <th>Alat</th>
                <th style="width: 70px;">Tgl Pinjam</th>
                <th style="width: 70px;">Tgl Kembali</th>
                <th style="width: 60px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="font-family: monospace;">{{ $b->borrowing_code }}</td>
                    <td>{{ $b->user->name }}</td>
                    <td>{{ $b->user->class ?? '-' }}</td>
                    <td>
                        @foreach($b->details as $d)
                            • {{ $d->tool->name }} ({{ $d->quantity }}x)<br>
                        @endforeach
                    </td>
                    <td>{{ $b->borrowing_date->format('d/m/Y') }}</td>
                    <td>{{ $b->return_date->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $badgeClass = match($b->status) {
                                'Pending' => 'badge-pending',
                                'Approved' => 'badge-approved',
                                'Rejected' => 'badge-rejected',
                                'Returned' => 'badge-returned',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $b->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak otomatis oleh SIPAL &mdash; {{ now()->format('d M Y H:i:s') }}</p>
    </div>

</body>
</html>