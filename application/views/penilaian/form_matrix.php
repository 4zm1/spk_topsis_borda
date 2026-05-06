<style>
    /* --- CSS DASAR (DEFAULT) --- */
    .table-responsive {
        max-height: 70vh;
        overflow: auto;
        border-radius: 8px;
    }
    
    /* Sticky Header & Column (Agar tabel nyaman digunakan) */
    .table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
    }
    .table .sticky-col {
        position: sticky;
        left: 0;
        z-index: 5;
        border-right: 1px solid #dee2e6;
    }
    .table thead th.sticky-col { z-index: 15; }

    /* --- LOGIKA DARK MODE OTOMATIS (Sesuai Template Vuexy) --- */
    
    /* 1. Jika Mode Terang (Light) */
    html:not(.dark-style) .card { background-color: #fff; }
    html:not(.dark-style) .sticky-col { background-color: #fff; }
    html:not(.dark-style) .table thead th { background-color: #f8f9fa; color: #5e5873; }

    /* 2. Jika Mode Gelap (Dark) */
    html.dark-style .card {
        background-color: #2f3349 !important; /* Warna Kartu Dark Vuexy */
        color: #b6bee3 !important; /* Warna Teks Dark */
    }
    html.dark-style .card-header {
        border-bottom-color: #434968 !important;
    }
    html.dark-style .table {
        color: #b6bee3 !important;
        border-color: #434968 !important;
    }
    html.dark-style .table-bordered td, 
    html.dark-style .table-bordered th {
        border-color: #434968 !important;
    }
    html.dark-style .table thead th {
        background-color: #3f445e !important; /* Header Tabel Lebih Terang Dikit */
        color: #d0d2d6 !important;
    }
    html.dark-style .sticky-col {
        background-color: #2f3349 !important; /* Samakan dengan warna kartu */
        border-right: 1px solid #434968 !important;
        color: #d0d2d6 !important;
    }
    html.dark-style .form-control, 
    html.dark-style .form-select,
    html.dark-style .input-group-text {
        background-color: #25293c !important; /* Input lebih gelap */
        border-color: #434968 !important;
        color: #d0d2d6 !important;
    }
    html.dark-style .text-muted {
        color: #7983bb !important;
    }
    
    /* Hover Effect di Dark Mode */
    html.dark-style .table-hover tbody tr:hover td {
        background-color: #363b54 !important;
    }
    html.dark-style .table-hover tbody tr:hover .sticky-col {
        background-color: #363b54 !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold py-1 mb-0"><span class="text-muted fw-light">Penilaian /</span> Input Data</h4>
        <small class="text-muted">Penilai Aktif: <b><?= $penilai_terpilih->nama_penilai ?></b></small>
    </div>
    <!-- <a href="<?= base_url('penilaian') ?>" class="btn btn-label-secondary waves-effect">
        <i class="ti ti-arrow-left me-1"></i> Kembali
    </a> -->
</div>

<div class="card shadow-sm">
    <div class="card-header border-bottom py-3 d-flex align-items-center justify-content-between">
        <h5 class="mb-0 text-primary fw-bold"><i class="ti ti-edit me-2"></i>Formulir Penilaian</h5>
        <span class="badge bg-label-primary rounded-pill px-3">
            <i class="ti ti-user me-1"></i> <?= $penilai_terpilih->nama_penilai ?>
        </span>
    </div>
    
    <div class="alert alert-primary alert-dismissible m-3 d-flex align-items-center" role="alert">
        <i class="ti ti-info-circle fs-4 me-2"></i>
        <div>Silakan isi nilai untuk setiap alternatif. Pastikan semua kolom terisi.</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="card-body p-0">
        <form action="<?= base_url('penilaian/simpan') ?>" method="post">
            <input type="hidden" name="id_penilai" value="<?= $penilai_terpilih->id_penilai ?>">
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 text-nowrap align-middle">
                    <thead class="text-center">
                        <tr>
                            <th rowspan="2" class="align-middle sticky-col fw-bolder" width="250px">
                                Alternatif Kandidat
                            </th>
                            <th colspan="<?= count($kriteria) ?>" class="text-primary fw-bold" style="letter-spacing: 1px;">
                                KRITERIA PENILAIAN
                            </th>
                        </tr>
                        <tr>
                            <?php foreach($kriteria as $k): ?>
                                <th class="text-center" style="min-width: 200px;">
                                    <span class="badge bg-primary mb-2"><?= $k->kode_kriteria ?></span>
                                    <div class="small fw-bold text-wrap" style="line-height: 1.2; width: 150px; margin: 0 auto;">
                                        <?= $k->nama_kriteria ?>
                                    </div>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($alternatif as $a): ?>
                        <tr>
                            <td class="sticky-col fw-bold">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <span class="avatar-initial rounded-circle bg-label-info">
                                            <?= substr($a->nama_alternatif, 0, 1) ?>
                                        </span>
                                    </div>
                                    <?= $a->nama_alternatif ?>
                                </div>
                            </td>
                            
                            <?php foreach($kriteria as $k): ?>
                                <td class="text-center p-3">
                                    <?php 
                                        $val = isset($nilai_existing[$a->id_alternatif][$k->id_kriteria]) 
                                                ? $nilai_existing[$a->id_alternatif][$k->id_kriteria] 
                                                : ''; 

                                        if (isset($sub_kriteria_map[$k->id_kriteria])): 
                                    ?>
                                        <select class="form-select form-select-sm text-center" 
                                                name="nilai[<?= $a->id_alternatif ?>][<?= $k->id_kriteria ?>]" required>
                                            <option value="" class="text-muted small">-- Pilih --</option>
                                            <?php foreach($sub_kriteria_map[$k->id_kriteria] as $sub): ?>
                                                <option value="<?= $sub->nilai ?>" <?= ($val == $sub->nilai) ? 'selected' : '' ?>>
                                                    <?= $sub->nama_sub ?> (Poin: <?= $sub->nilai ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    
                                    <?php else: ?>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">
                                                <small>Nilai</small>
                                            </span>
                                            <input type="number" step="any" class="form-control fw-bold text-center text-primary" 
                                                   name="nilai[<?= $a->id_alternatif ?>][<?= $k->id_kriteria ?>]" 
                                                   value="<?= $val ?>" required placeholder="0">
                                        </div>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center py-3">
                <small class="text-muted fst-italic">
                    * Pastikan seluruh data terisi dengan benar sebelum menyimpan.
                </small>
                <button type="submit" class="btn btn-primary btn-lg fw-bold px-4 shadow-sm">
                    <i class="ti ti-device-floppy me-2"></i> Simpan Data Penilaian
                </button>
            </div>
        </form>
    </div>
</div>