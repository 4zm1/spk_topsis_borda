<style>
    /* --- CSS KHUSUS TAMPILAN WEB --- */
    .winner-card-bg {
        background: linear-gradient(135deg, #7367F0 0%, #9e95f5 100%);
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 15px rgba(115, 103, 240, 0.4);
    }
    .winner-card-bg::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .badge-gradient-primary {
        background: linear-gradient(45deg, #7367F0, #00cfe8);
        color: white;
        border: none;
        box-shadow: 0 3px 6px rgba(115, 103, 240, 0.3);
    }

    .badge-rank-1 { background-color: #28c76f; color: white; box-shadow: 0 2px 5px rgba(40, 199, 111, 0.4); } 
    .badge-rank-2 { background-color: #00cfe8; color: white; box-shadow: 0 2px 5px rgba(0, 207, 232, 0.4); }
    .badge-rank-3 { background-color: #ff9f43; color: white; box-shadow: 0 2px 5px rgba(255, 159, 67, 0.4); }
    .badge-rank-other { background-color: #ea5455; color: white; opacity: 0.8; }

    .table-hover tbody tr:hover {
        background-color: rgba(115, 103, 240, 0.05);
        transition: all 0.2s ease;
    }

    /* --- LOGIKA DARK MODE (Vuexy Style) --- */
    html.dark-style .card {
        background-color: #2f3349 !important;
        color: #b6bee3 !important;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2) !important;
    }
    html.dark-style .card-header {
        border-bottom-color: #434968 !important;
        background-color: #2f3349 !important;
    }
    html.dark-style .bg-light, 
    html.dark-style .table-light th {
        background-color: #3f445e !important; /* Header Tabel Gelap */
        color: #d0d2d6 !important;
    }
    html.dark-style .table {
        color: #b6bee3 !important;
        border-color: #434968 !important;
    }
    html.dark-style .table-bordered td, 
    html.dark-style .table-bordered th {
        border-color: #434968 !important;
    }
    html.dark-style .table-hover tbody tr:hover td {
        background-color: #363b54 !important;
    }
    html.dark-style .text-dark {
        color: #d0d2d6 !important;
    }
    html.dark-style .text-muted {
        color: #7983bb !important;
    }
    html.dark-style .nav-pills .nav-link {
        color: #b6bee3;
    }
    html.dark-style .nav-pills .nav-link.active {
        color: #fff !important;
        box-shadow: 0 2px 4px 0 rgba(115, 103, 240, 0.4);
    }
    /* Warna Progress Bar Background di Dark Mode */
    html.dark-style .progress {
        background-color: #434968 !important;
    }

    /* --- CSS KHUSUS CETAK (PRINT) --- */
    @media print {
        body * { visibility: hidden; }
        .layout-navbar, .layout-menu, .btn-print-area { display: none !important; }
        #printableArea, #printableArea * { visibility: visible; }
        #printableArea { position: absolute; left: 0; top: 0; width: 100%; }
        .card { border: 1px solid #ddd !important; box-shadow: none !important; background-color: #fff !important; color: #000 !important; }
        .badge { border: 1px solid #000; color: #000 !important; box-shadow: none !important; background: none !important; }
        .nav-pills { display: none; } 
        .tab-content { display: block !important; }
        .tab-pane { display: block !important; opacity: 1 !important; margin-bottom: 20px; page-break-inside: avoid; }
        
        /* Reset Warna Teks Saat Print */
        .text-dark { color: #000 !important; }
        .text-muted { color: #333 !important; }
    }
</style>

<div id="printableArea">
    <div class="d-flex justify-content-between align-items-center mb-4 btn-print-area">
        <div>
            <h4 class="fw-bold py-1 mb-0"><span class="text-muted fw-light">Laporan /</span> Hasil Akhir</h4>
            <small class="text-muted">Analisis Komprehensif SPK Metode Borda & TOPSIS</small>
        </div>
        <div>
            <a href="<?= base_url('spk/cetak') ?>" target="_blank" class="btn btn-label-secondary waves-effect fw-bold me-2">
                <i class="ti ti-printer me-1"></i> Cetak Laporan
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-4 mb-md-0">
            <?php 
                $juara = isset($hasil_borda[0]) ? $hasil_borda[0] : null;
            ?>
            <div class="card h-100 winner-card-bg shadow-lg text-center border-0">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="avatar avatar-xl border border-3 border-white rounded-circle p-1 mb-3 bg-white bg-opacity-25">
                        <span class="avatar-initial rounded-circle bg-white text-primary">
                            <i class="ti ti-crown ti-xl fs-1"></i>
                        </span>
                    </div>
                    
                    <h6 class="text-white text-uppercase letter-spacing-1 mb-1 fw-bold">Rekomendasi Terbaik</h6>
                    <h2 class="text-white fw-bolder mb-1"><?= $juara ? $juara['nama'] : '-' ?></h2>
                    <span class="badge bg-white text-primary fw-bolder px-4 py-2 fs-5 mt-2 shadow-sm rounded-pill">Total Poin: <?= $juara ? $juara['poin'] : 0 ?></span>

                    <hr class="border-white border-opacity-25 w-100 my-4">

                    <div class="row w-100 text-center text-white">
                        <div class="col-6 border-end border-white border-opacity-25">
                            <h5 class="mb-0 text-white fw-bold"><i class="ti ti-check"></i></h5>
                            <small class="text-white text-opacity-75">Status Valid</small>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-0 text-white fw-bold">#1</h5>
                            <small class="text-white text-opacity-75">Peringkat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-list-numbers me-2 text-primary"></i>Peringkat Lengkap</h5>
                    <small class="text-muted">Metode Borda</small>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" width="10%">#</th>
                                <th>Alternatif</th>
                                <th class="text-center">Poin</th>
                                <th>Detail Suara Penilai</th>
                                <th class="text-center">Keputusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($hasil_borda as $row): ?>
                            <tr>
                                <td class="text-center">
                                    <?php if($no == 1): ?>
                                        <div class="avatar avatar-xs mx-auto">
                                            <span class="avatar-initial rounded-circle bg-warning text-white">
                                                <i class="ti ti-trophy fs-6"></i>
                                            </span>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-label-secondary rounded-circle p-2" style="width:30px; height:30px; display:flex; align-items:center; justify-content:center;"><?= $no ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold text-dark fs-6"><?= $row['nama'] ?></td>
                                <td class="text-center">
                                    <span class="badge badge-gradient-primary rounded-pill px-3 py-2 fs-6 fw-bold">
                                        <?= $row['poin'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php foreach($row['detail_rank'] as $penilai => $info): 
                                            preg_match('/Rank (\d+)/', $info, $matches);
                                            $rank_val = $matches[1] ?? '-';
                                        ?>
                                            <span class="badge bg-label-secondary border" style="font-size: 0.7rem;" data-bs-toggle="tooltip" title="<?= $penilai ?> memberikan <?= $info ?>">
                                                <i class="ti ti-user me-1"></i><?= substr($penilai, -1) ?>: <b>#<?= $rank_val ?></b>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if($no == 1): ?>
                                        <i class="ti ti-circle-check-filled text-success fs-3"></i>
                                    <?php else: ?>
                                        <i class="ti ti-circle-minus text-muted fs-4"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 btn-print-area" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active waves-effect waves-light fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#tab-summary">
                            <i class="ti ti-presentation-analytics me-1"></i> Info
                        </button>
                    </li>
                    <?php foreach ($hasil_per_penilai as $nama_penilai => $hasil): 
                        $slug = str_replace(' ', '', $nama_penilai);
                    ?>
                    <li class="nav-item">
                        <button type="button" class="nav-link waves-effect waves-light fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#tab-<?= $slug ?>">
                            <i class="ti ti-user-circle me-1"></i> <?= $nama_penilai ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content shadow-sm border-0 rounded-3">
                    <div class="tab-pane fade show active" id="tab-summary" role="tabpanel">
                        <div class="p-4 text-center">
                            <div class="mb-3">
                                <span class="avatar avatar-xl rounded bg-label-primary p-3">
                                    <i class="ti ti-chart-dots fs-1"></i>
                                </span>
                            </div>
                            <h4>Detail Perhitungan TOPSIS</h4>
                            <p class="text-muted max-w-500 mx-auto">
                                Bagian ini menampilkan nilai preferensi (V) yang dihasilkan oleh setiap penilai secara independen sebelum digabungkan menggunakan metode Borda.
                            </p>
                        </div>
                    </div>

                    <?php foreach ($hasil_per_penilai as $nama_penilai => $hasil): 
                        $slug = str_replace(' ', '', $nama_penilai);
                    ?>
                    <div class="tab-pane fade" id="tab-<?= $slug ?>" role="tabpanel">
                        <div class="card-header px-0 pt-0 pb-3 border-bottom mb-3">
                            <h5 class="mb-0 text-primary fw-bold"><i class="ti ti-file-analytics me-2"></i>Hasil Penilaian: <?= $nama_penilai ?></h5>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="5%">Rank</th>
                                        <th width="30%">Alternatif</th>
                                        <th class="text-center" width="20%">Nilai Preferensi (V)</th>
                                        <th>Visualisasi Jarak Solusi Ideal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rank = 1; foreach ($hasil as $h): 
                                        $percent = $h['nilai_v'] * 100;
                                        if($rank == 1) { $badge_cls = 'badge-rank-1'; $bar_bg = 'bg-success'; }
                                        elseif($rank == 2) { $badge_cls = 'badge-rank-2'; $bar_bg = 'bg-info'; }
                                        elseif($rank == 3) { $badge_cls = 'badge-rank-3'; $bar_bg = 'bg-warning'; }
                                        else { $badge_cls = 'badge-rank-other'; $bar_bg = 'bg-secondary'; }
                                    ?>
                                    <tr>
                                        <td class="text-center fw-bold"><?= $rank ?></td>
                                        <td class="fw-bold"><?= $h['nama'] ?></td>
                                        <td class="text-center">
                                            <span class="badge <?= $badge_cls ?> rounded-pill px-3 font-monospace fs-6">
                                                <?= number_format($h['nilai_v'], 5) ?>
                                            </span>
                                        </td>
                                        <td class="align-middle px-3">
                                            <div class="progress" style="height: 10px; background-color: #e9ecef; border-radius: 5px;">
                                                <div class="progress-bar <?= $bar_bg ?> progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= $percent ?>%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $rank++; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-end">
                            <small class="text-muted"><i class="ti ti-info-circle me-1"></i>Data diurutkan dari nilai V tertinggi (Terbaik).</small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>