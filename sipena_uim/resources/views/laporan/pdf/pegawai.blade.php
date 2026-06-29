<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        .kop { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 15px; }
        .kop h2 { margin: 0; font-size: 13pt; }
        .kop p { margin: 2px 0; font-size: 9pt; }
        h3 { font-size: 11pt; text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1E3A5F; color: white; padding: 6px 8px; text-align: left; font-size: 9pt; }
        td { padding: 5px 8px; border: 1px solid #ddd; font-size: 9pt; }
        tr:nth-child(even) { background: #f5f5f5; }
        .footer { margin-top: 30px; text-align: right; font-size: 9pt; }
    </style>
</head>
<body>
<div class="kop">
    <h2>UNIVERSITAS ISLAM MULIA</h2>
    <p>Laporan Data Kepegawaian | {{ now()->format('d F Y') }}</p>
</div>
<h3>REKAP DATA PEGAWAI</h3>
<table>
    <thead>
        <tr>
            <th width="30">No</th>
            <th>Nama Lengkap</th>
            <th>NIP/NIDN</th>
            <th>Jenis</th>
            <th>Jabatan Aktif</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pegawais as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->nama_lengkap }}</td>
            <td>{{ $p->nip ?? $p->nidn ?? '-' }}</td>
            <td>{{ ucfirst($p->jenis_pegawai) }}</td>
            <td>{{ $p->jabatanAktif->pluck('nama')->implode(', ') ?: '-' }}</td>
            <td>{{ ucfirst($p->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="footer">
    <p>Total: {{ $pegawais->count() }} pegawai | Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
</div>
</body>
</html>