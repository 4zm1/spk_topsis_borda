<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil SPK</title>
    <style>
        /* RESET & FONT */
        * { box-sizing: border-box; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5; /* Abu-abu di layar */
        }

        /* TAMPILAN KERTAS A4 */
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        /* HEADER / KOP SURAT MODERN */
        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-left h1 {
            margin: 0;
            font-size: 18pt;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-left p { margin: 5px 0 0; color: #555; }
        .header-right { text-align: right; }
        .tgl-cetak {
            font-size: 10px;
            color: #888;
            margin-top: 5px;
        }

        /* JUDUL DOKUMEN */
        .doc-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
            text-decoration: underline;
        }
        .doc-desc {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
            font-style: italic;
        }

        /* KOTAK JUARA (HIGHLIGHT) */
        .winner-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-left: 5px solid #28c76f; /* Aksen Hijau */
            padding: 15px 20px;
            margin-bottom: 30px;
            border-radius: 4px;
        }
        .winner-title { font-size: 10px; text-transform: uppercase; color: #666; font-weight: bold; letter-spacing: 1px; }
        .winner-name { font-size: 16pt; font-weight: bold; color: #2c3e50; margin: 5px 0; }
        .winner-score { font-size: 11px; color: #28c76f; font-weight: bold; }

        /* TABEL PROFESIONAL */
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th {
            background-color: #2c3e50; /* Header Gelap */
            color: white;
            padding: 10px;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            color: #333;
        }
        tr:nth-child(even) { background-color: #f9f9f9; } /* Zebra Striping */
        
        /* Kolom Khusus */
        .col-rank { font-weight: bold; text-align: center; width: 50px; }
        .col-poin { font-weight: bold; text-align: center; width: 100px; }
        .col-status { text-align: center; width: 150px; }

        /* BADGE STATUS */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            display: inline-block;
        }
        .bg-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .bg-light { background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; }

        /* TANDA TANGAN */
        .signature-grid {
            display: flex;
            justify-content: flex-end;
            margin-top: 50px;
        }
        .signature-box {
            width: 200px;
            text-align: center;
        }
        .sign-space { height: 70px; }
        .sign-name { font-weight: bold; text-decoration: underline; }

        /* TOMBOL (Screen Only) */
        .no-print {
            position: fixed; top: 20px; right: 20px; z-index: 1000;
            display: flex; gap: 10px;
        }
        .btn {
            padding: 10px 20px; border: none; border-radius: 5px; 
            color: white; font-weight: bold; cursor: pointer; text-decoration: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn-print { background: #007bff; }
        .btn-back { background: #6c757d; }

        /* PRINT CONFIG */
        @media print {
            body { background: white; }
            .page { width: 100%; margin: 0; box-shadow: none; padding: 0; }
            .no-print { display: none; }
            @page { margin: 2cm; size: A4; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <a href="<?= base_url('spk') ?>" class="btn btn-back">&laquo; Kembali</a>
        <button onclick="window.print()" class="btn btn-print">Simpan PDF</button>
    </div>

    <div class="page">
        
        <div class="header">
            <div class="header-left">
                <h1>PT. PERUSAHAAN ANDA</h1>
                <p>Jl. Jendral Sudirman No. 123, Jakarta Pusat<br>
                Telp: (021) 1234-5678 | Email: info@perusahaan.com</p>
            </div>
            <div class="header-right">
                <img src="https://via.placeholder.com/80x80?text=LOGO" alt="Logo" style="height: 60px; opacity: 0.6;">
                <div class="tgl-cetak">Dicetak: <?= date('d/m/Y H:i') ?></div>
            </div>
        </div>

        <div class="doc-title">LAPORAN HASIL KEPUTUSAN (SPK)</div>
        <div class="doc-desc">Metode Penggabungan Keputusan: TOPSIS & Borda</div>

        <?php 
            // SORTING DATA (Aman dari error)
            if(!empty($hasil_borda)) {
                usort($hasil_borda, function($a, $b) {
                    $a = (array)$a; $b = (array)$b;
                    if ($a['poin'] == $b['poin']) return 0;
                    return ($a['poin'] > $b['poin']) ? -1 : 1;
                });
                $juara = (array)$hasil_borda[0]; // Ambil data pertama
            } else {
                $juara = null;
            }
        ?>

        <?php if($juara): ?>
        <div class="winner-section">
            <div class="winner-title">Rekomendasi Terbaik (Peringkat 1)</div>
            <div class="winner-name"><?= $juara['nama'] ?></div>
            <div class="winner-score">Total Poin Perolehan: <?= number_format($juara['poin'], 0) ?> Poin</div>
        </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th class="col-rank">Rank</th>
                    <th>Nama Alternatif</th>
                    <th class="col-poin">Total Poin</th>
                    <th class="col-status">Keputusan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(empty($hasil_borda)): 
                    echo '<tr><td colspan="4" style="text-align:center; padding:20px;">Data Belum Tersedia</td></tr>';
                else:
                    $no = 1;
                    foreach($hasil_borda as $row):
                        $row = (array)$row;
                ?>
                <tr>
                    <td class="col-rank"><?= $no ?></td>
                    <td style="font-weight: 500;"><?= $row['nama'] ?></td>
                    <td class="col-poin"><?= number_format($row['poin'], 0) ?></td>
                    <td class="col-status">
                        <?php if($no == 1): ?>
                            <span class="badge bg-success">Sangat Layak</span>
                        <?php elseif($no <= 3): ?>
                            <span class="badge bg-light">Layak</span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php $no++; endforeach; endif; ?>
            </tbody>
        </table>

        <div class="signature-grid">
            <div class="signature-box">
                <p>Jakarta, <?= date('d F Y') ?></p>
                <p>Mengetahui,</p>
                <div class="sign-space"></div>
                <div class="sign-name"><?= $this->session->userdata('nama') ?></div>
                <div>Administrator</div>
            </div>
        </div>

    </div>

</body>
</html>