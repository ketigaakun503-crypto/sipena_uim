<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; margin: 0; padding: 0; color: #000; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop h2 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .kop p { margin: 2px 0; font-size: 10pt; }
        .nomor { margin-bottom: 20px; }
        .isi { text-align: justify; line-height: 1.8; }
        table.data { width: 100%; margin: 15px 0; }
        table.data td { padding: 3px 0; vertical-align: top; }
        table.data td:first-child { width: 220px; }
        table.data td:nth-child(2) { width: 10px; }
        .ttd { margin-top: 40px; }
        .ttd table { width: 100%; }
        .ttd td { vertical-align: top; }
        .ttd .kanan { text-align: center; float: right; width: 250px; }
        .garis-ttd { margin-top: 70px; border-top: 1px solid #000; width: 200px; margin-left: auto; margin-right: auto; }
    </style>
</head>
<body>

{{-- KOP SURAT --}}
<div class="kop">
    <table width="100%">
        <tr>
            <td width="80" style="text-align:center">
                <div style="width:70px; height:70px; border:2px solid #000; text-align:center; line-height:70px; font-size:8pt;">LOGO UIM</div>
            </td>
            <td style="text-align:center">
                <h2>UNIVERSITAS ISLAM MULIA</h2>
                <p>Jl. Contoh No. 1, Yogyakarta 55000</p>
                <p>Telp. (0274) 000000 | Email: info@uim.ac.id</p>
            </td>
        </tr>
    </table>
</div>

{{-- NOMOR SURAT --}}
<div class="nomor">
    <table class="data">
        <tr>
            <td>Nomor</td><td>:</td>
            <td>{{ $surat->nomor_surat }}</td>
        </tr>
        <tr>
            <td>Perihal</td><td>:</td>
            <td>Surat Pengantar Pengajuan Jabatan Fungsional</td>
        </tr>
    </table>
</div>

{{-- ISI SURAT --}}
<div class="isi">
    <p>Yang bertanda tangan di bawah ini, Rektor Universitas Islam Mulia, dengan ini menerangkan bahwa:</p>

    <table class="data">
        <tr><td>Nama</td><td>:</td><td>{{ $surat->pegawai->nama_lengkap }}</td></tr>
        <tr><td>NIDN</td><td>:</td><td>{{ $surat->pegawai->nidn ?? '-' }}</td></tr>
        <tr><td>Jabatan Fungsional Sekarang</td><td>:</td><td>{{ $surat->jabatan_fungsional_sekarang }}</td></tr>
        <tr><td>Jabatan Fungsional Diajukan</td><td>:</td><td>{{ $surat->jabatan_fungsional_diajukan }}</td></tr>
        <tr><td>Pangkat/Golongan</td><td>:</td><td>{{ $surat->pangkat_golongan }}</td></tr>
        <tr><td>TMT Pangkat</td><td>:</td><td>{{ $surat->tmt_pangkat->format('d F Y') }}</td></tr>
    </table>

    <p>
        Adalah benar merupakan Dosen tetap di Universitas Islam Mulia dan yang bersangkutan
        mengajukan kenaikan Jabatan Fungsional dari <strong>{{ $surat->jabatan_fungsional_sekarang }}</strong>
        menjadi <strong>{{ $surat->jabatan_fungsional_diajukan }}</strong>.
    </p>

    <p>Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
</div>

{{-- TANDA TANGAN --}}
<div class="ttd">
    <table width="100%">
        <tr>
            <td width="50%"></td>
            <td width="50%" style="text-align:center">
                <p>Yogyakarta, {{ now()->format('d F Y') }}</p>
                <p><strong>Rektor,</strong></p>
                <br><br><br><br>
                <p><strong><u>.................................</u></strong></p>
                <p>NIP. .................................</p>
            </td>
        </tr>
    </table>
</div>

</body>
</html>