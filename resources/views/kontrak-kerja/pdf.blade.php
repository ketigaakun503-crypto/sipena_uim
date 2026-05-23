<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; color: #000; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop h2 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .kop p { margin: 2px 0; font-size: 9pt; }
        h3 { text-align: center; font-size: 13pt; margin: 15px 0; text-transform: uppercase; text-decoration: underline; }
        table.data { width: 100%; margin: 15px 0; }
        table.data td { padding: 4px 0; vertical-align: top; }
        table.data td:first-child { width: 200px; }
        table.data td:nth-child(2) { width: 10px; }
        .isi { text-align: justify; line-height: 1.8; }
        .ttd { margin-top: 50px; }
    </style>
</head>
<body>
<div class="kop">
    <table width="100%"><tr>
        <td width="80" style="text-align:center">
            <div style="width:70px;height:70px;border:2px solid #000;text-align:center;line-height:70px;font-size:8pt;">LOGO</div>
        </td>
        <td style="text-align:center">
            <h2>Universitas Islam Mulia</h2>
            <p>Jl. Contoh No. 1, Yogyakarta 55000</p>
            <p>Telp. (0274) 000000 | Email: info@uim.ac.id</p>
        </td>
    </tr></table>
</div>

<h3>Kontrak Kerja</h3>

<div class="isi">
    <p>Nomor: <strong>{{ $kontrak->nomor_kontrak }}</strong></p>
    <p>Pada hari ini, {{ now()->format('d F Y') }}, Universitas Islam Mulia telah menetapkan kontrak kerja kepada:</p>

    <table class="data">
        <tr><td>Nama Lengkap</td><td>:</td><td>{{ $kontrak->pegawai->nama_lengkap }}</td></tr>
        <tr><td>NIP/NIDN</td><td>:</td><td>{{ $kontrak->pegawai->nip ?? $kontrak->pegawai->nidn ?? '-' }}</td></tr>
        <tr><td>Jenis Pegawai</td><td>:</td><td>{{ ucfirst($kontrak->pegawai->jenis_pegawai) }}</td></tr>
        <tr><td>Jenis Kontrak</td><td>:</td><td>{{ ucwords(str_replace('_', ' ', $kontrak->jenis_kontrak)) }}</td></tr>
        <tr><td>Tanggal Mulai</td><td>:</td><td>{{ $kontrak->tanggal_mulai->format('d F Y') }}</td></tr>
        <tr><td>Tanggal Selesai</td><td>:</td><td>{{ $kontrak->tanggal_selesai ? $kontrak->tanggal_selesai->format('d F Y') : 'Tidak terbatas' }}</td></tr>
        @if($kontrak->keterangan)
        <tr><td>Keterangan</td><td>:</td><td>{{ $kontrak->keterangan }}</td></tr>
        @endif
    </table>

    <p>Demikian kontrak kerja ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
</div>

<div class="ttd">
    <table width="100%"><tr>
        <td width="50%"></td>
        <td width="50%" style="text-align:center">
            <p>Yogyakarta, {{ now()->format('d F Y') }}</p>
            <p><strong>Rektor,</strong></p>
            <br><br><br>
            <p><strong><u>.................................</u></strong></p>
            <p>NIP. .................................</p>
        </td>
    </tr></table>
</div>
</body>
</html>