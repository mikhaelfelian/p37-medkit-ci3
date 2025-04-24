<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 12px;
            margin-bottom: 10px;
        }
        .content {
            margin: 20px 0;
        }
        .patient-info {
            margin-bottom: 20px;
        }
        .patient-info p {
            margin: 5px 0;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
        }
        .signature p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">SURAT KETERANGAN <?php echo strtoupper(general::tipe_surat($sql_medc_srt->tipe)); ?></div>
        <div class="subtitle">Nomor: <?php echo $sql_medc_srt->no_surat; ?></div>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, dokter di <?php echo $setting->judul; ?>, menerangkan bahwa:</p>

        <div class="patient-info">
            <p><strong>Nama Lengkap:</strong> <?php echo $sql_pasien->nama_pgl; ?></p>
            <p><strong>Tanggal Lahir:</strong> <?php echo $this->tanggalan->tgl_indo2($sql_pasien->tgl_lahir); ?></p>
            <p><strong>Jenis Kelamin:</strong> <?php echo general::jns_klm($sql_pasien->jns_klm); ?></p>
            <p><strong>Pekerjaan:</strong> <?php echo $sql_pekerjaan->jenis; ?></p>
            <p><strong>Alamat:</strong> <?php echo !empty($sql_pasien->alamat) ? $sql_pasien->alamat : (!empty($sql_pasien->alamat_dom) ? $sql_pasien->alamat_dom : '-'); ?></p>
        </div>

        <?php if ($sql_medc_srt->tipe == '1'): ?>
            <p>Bahwa yang bersangkutan telah menjalani pemeriksaan kesehatan di <?php echo $setting->judul; ?> dan dinyatakan dalam keadaan sehat.</p>
        <?php elseif ($sql_medc_srt->tipe == '2'): ?>
            <p>Bahwa yang bersangkutan perlu beristirahat karena sakit sehingga tidak dapat melaksanakan kewajibannya, selama <?php echo $sql_medc_srt->jml_hari; ?> hari terhitung mulai tanggal <?php echo $this->tanggalan->tgl_indo2($sql_medc_srt->tgl_masuk); ?> s/d <?php echo ($sql_medc_srt->status_sembuh == '1' ? 'Sembuh' : ($sql_medc_srt->tgl_keluar != '0000-00-00' ? $this->tanggalan->tgl_indo2($sql_medc_srt->tgl_keluar) : '-')); ?>.</p>
        <?php elseif ($sql_medc_srt->tipe == '3'): ?>
            <p>Bahwa pasien sedang dalam perawatan di kamar rawat inap kami, sehingga tidak dapat melaksanakan kewajibannya mulai tanggal <?php echo $this->tanggalan->tgl_indo2($sql_medc_srt->tgl_masuk); ?> s/d <?php echo ($sql_medc_srt->status_sembuh == '1' ? 'Sembuh' : $this->tanggalan->tgl_indo2($sql_medc_srt->tgl_keluar)); ?>.</p>
        <?php endif; ?>

        <p>Demikian surat ini dibuat agar dapat digunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Semarang, <?php echo $this->tanggalan->tgl_indo3($sql_medc_srt->tgl_masuk); ?></p>
            <p>Dokter yang memeriksa,</p>
            <br><br><br>
            <p><?php echo (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn . ' ' : '') . $sql_dokter->nama . (!empty($sql_dokter->nama_blk) ? ', ' . $sql_dokter->nama_blk : ''); ?></p>
            <p><?php echo $sql_dokter->nik; ?></p>
        </div>
    </div>
</body>
</html> 