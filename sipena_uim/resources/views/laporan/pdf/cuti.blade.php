<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        .kop { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 15px; }
        .kop h2 { margin: 0; font-size: 13pt; }
        h3 { font-size: 11pt; text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1E3A5F; color: white; padding: 6px 8px; text-align: left; font-size: 9pt; }
        td { padding: 5px 8px; border: 1px solid #ddd; font-size: 9pt; }
        tr:nth-child(even) { background: #f5f5f5; }
        .footer { margin-top: 20px; text-align: right; font-size: 9pt; }
    </style>
</head>
<body>
<div class="kop">
    <h2>UNIVERSITAS ISLAM MULIA</h2>
    <p>Laporan Rekap Cuti | {{ now()->format('d F Y') }}</p>
</div>
<h3>REKAP PENGAJUAN CUTI</h3>
<table>
    <thead>
        <tr>
            <th width="30">No</th>
            <th>Nama Pegawai</th>
            <th>Jenis Cuti</th>
            <th>Tgl Mulai</th>
            <th>Tgl Selesai</th>
            <th>Hari</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengajuan as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->pegawai->nama_lengkap }}</td>
            <td>{{ ucwords(str_replace('_', ' ', $p->jenis_cuti)) }}</td>
            <td>{{ $p->tanggal_mulai->format('d/m/Y') }}</td>
            <td>{{ $p->tanggal_selesai->format('d/m/Y') }}</td>
            <td>{{ $p->jumlah_hari }}</td>
            <td>{{ ucfirst($p->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="footer">
    <p>Total: {{ $pengajuan->count() }} pengajuan | Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
</div>
</body>
</html>