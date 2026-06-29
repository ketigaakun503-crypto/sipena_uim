<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; color: #000; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop h2 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        h3 { text-align: center; font-size: 13pt; margin: 15px 0; text-transform: uppercase; text-decoration: underline; }
        table.data { width: 100%; margin: 15px 0; }
        table.data td { padding: 4px 0; vertical-align: top; }
        table.data td:first-child { width: 220px; }
        .isi { text-align: justify; line-height: 1.8; }
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

<h3>Surat Keputusan<br>{{ $sk->jenis_sk_label }}</h3>
<p style="text-align:center">Nomor: {{ $sk->nomor_sk }}</p>

<div class="isi">
    @if($sk->pertimbangan)
    <p><strong>Menimbang:</strong></p>
    <p style="padding-left:20px">{{ $sk->pertimbangan }}</p>
    @endif

    <p><strong>Memutuskan / Menetapkan:</strong></p>

    <table class="data">
        <tr><td>Kepada</td><td>:</td><td>{{ $sk->pegawai->nama_lengkap }}</td></tr>
        <tr><td>NIDN / NIP</td><td>:</td><td>{{ $sk->pegawai->nidn ?? $sk->pegawai->nip ?? '-' }}</td></tr>
        <tr><td>Jabatan</td><td>:</td><td>{{ $sk->jabatan_yang_ditetapkan }}</td></tr>
        <tr><td>Tanggal SK</td><td>:</td><td>{{ $sk->tanggal_sk->format('d F Y') }}</td></tr>
        @if($sk->tmt)
        <tr><td>Terhitung Mulai Tanggal</td><td>:</td><td>{{ $sk->tmt->format('d F Y') }}</td></tr>
        @endif
        @if($sk->keterangan)
        <tr><td>Keterangan</td><td>:</td><td>{{ $sk->keterangan }}</td></tr>
        @endif
    </table>

    <p>Ditetapkan di Yogyakarta pada tanggal {{ $sk->tanggal_sk->format('d F Y') }}.</p>
</div>

<div style="margin-top:50px">
    <table width="100%"><tr>
        <td width="50%"></td>
        <td width="50%" style="text-align:center">
            <p><strong>Rektor,</strong></p>
            <br><br><br>
            <p><strong><u>.................................</u></strong></p>
            <p>NIP. .................................</p>
        </td>
    </tr></table>
</div>
</body>
</html>