<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; color: #000; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop h2 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .kop p { margin: 2px 0; font-size: 10pt; }
        table.data { width: 100%; margin: 15px 0; }
        table.data td { padding: 4px 0; vertical-align: top; }
        table.data td:first-child { width: 220px; }
        table.data td:nth-child(2) { width: 10px; }
        .isi { text-align: justify; line-height: 1.8; }
    </style>
</head>
<body>

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

<table class="data">
    <tr><td>Nomor</td><td>:</td><td>{{ $surat->nomor_surat }}</td></tr>
    <tr><td>Perihal</td><td>:</td><td>Surat Pengantar Sertifikasi Dosen</td></tr>
</table>

<div class="isi">
    <p>Yang bertanda tangan di bawah ini, Rektor Universitas Islam Mulia, menerangkan bahwa:</p>

    <table class="data">
        <tr><td>Nama</td><td>:</td><td>{{ $surat->pegawai->nama_lengkap }}</td></tr>
        <tr><td>NIDN</td><td>:</td><td>{{ $surat->pegawai->nidn ?? '-' }}</td></tr>
        <tr><td>Program Studi</td><td>:</td><td>{{ $surat->program_studi }}</td></tr>
        <tr><td>Bidang Ilmu</td><td>:</td><td>{{ $surat->bidang_ilmu }}</td></tr>
        <tr><td>Jumlah SKS Mengajar</td><td>:</td><td>{{ $surat->jumlah_sks }} SKS</td></tr>
        <tr><td>Tahun Mulai Mengajar</td><td>:</td><td>{{ $surat->tahun_mulai_mengajar }}</td></tr>
    </table>

    <p>
        Adalah benar merupakan Dosen tetap di Universitas Islam Mulia dan yang bersangkutan
        diusulkan untuk mengikuti program <strong>Sertifikasi Dosen (Serdos)</strong>.
    </p>

    <p>Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
</div>

<div style="margin-top:50px;">
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