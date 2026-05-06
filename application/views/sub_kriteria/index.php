<style>
    /* --- CSS DASAR (LIGHT MODE) --- */
    .table-responsive { border-radius: 8px; }
    
    /* --- LOGIKA DARK MODE (Vuexy Style) --- */
    html.dark-style .card {
        background-color: #2f3349 !important;
        color: #b6bee3 !important;
    }
    html.dark-style .card-header {
        border-bottom-color: #434968 !important;
        background-color: #2f3349 !important; /* Timpa bg-white */
    }
    html.dark-style .bg-light {
        background-color: #3f445e !important; /* Ganti warna baris header tabel */
    }
    html.dark-style .bg-opacity-25 {
        background-color: rgba(63, 68, 94, 0.5) !important; /* Untuk empty state */
    }
    html.dark-style .table {
        color: #b6bee3 !important;
        border-color: #434968 !important;
    }
    html.dark-style .table-hover tbody tr:hover td {
        background-color: #363b54 !important;
    }
    html.dark-style .text-dark, 
    html.dark-style .text-heading {
        color: #d0d2d6 !important;
    }
    html.dark-style .text-muted {
        color: #7983bb !important;
    }
    html.dark-style .form-control, 
    html.dark-style .form-select,
    html.dark-style .input-group-text {
        background-color: #25293c !important;
        border-color: #434968 !important;
        color: #d0d2d6 !important;
    }
    html.dark-style .modal-content {
        background-color: #2f3349 !important;
        color: #b6bee3 !important;
    }
    html.dark-style .modal-header {
        border-bottom-color: #434968 !important;
    }
    html.dark-style .modal-footer {
        background-color: #2f3349 !important; /* Samakan dengan body modal */
        border-top-color: #434968 !important;
    }
    html.dark-style .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    html.dark-style .avatar.bg-white {
        background-color: #434968 !important; /* Avatar empty state */
    }
</style>

<div class="card mb-4 bg-transparent shadow-none">
    <div class="card-body p-0 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 fw-bolder text-primary">Master Sub Kriteria</h3>
            <p class="text-muted mb-0" style="font-size: 1.1rem;">Kelola parameter dan bobot nilai untuk setiap kriteria.</p>
        </div>
        <button type="button" class="btn btn-primary btn-lg waves-effect waves-light shadow-sm fw-bold" 
                data-bs-toggle="modal" data-bs-target="#modalSub" onclick="resetFormSub()">
            <i class="ti ti-plus me-2 fs-4"></i> Tambah Parameter
        </button>
    </div>
</div>

<div class="row">
    <?php foreach($grouped_sub as $group): ?>
        <?php 
            $k = $group['info']; 
            $subs = $group['subs'];
            
            // Warna & Ikon berdasarkan Benefit/Cost
            $is_benefit = ($k->jenis == 'Benefit');
            // Gunakan bg-label-* agar warna lebih soft dan adaptif
            $header_bg = $is_benefit ? 'bg-label-success' : 'bg-label-danger'; 
            $icon_type = $is_benefit ? 'ti-trending-up' : 'ti-trending-down';
        ?>
        <div class="col-12 mb-5">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header border-bottom py-3 px-4 d-flex justify-content-between align-items-center bg-white">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar avatar-lg rounded <?= $header_bg ?> d-flex align-items-center justify-content-center">
                            <span class="fw-bolder fs-4"><?= $k->kode_kriteria ?></span>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bolder text-dark"><?= $k->nama_kriteria ?></h4>
                            <div class="d-flex align-items-center gap-3 mt-1">
                                <span class="badge <?= $header_bg ?> fs-6 px-3">
                                    <i class="ti <?= $icon_type ?> me-1"></i> <?= $k->jenis ?>
                                </span>
                                <span class="text-dark fw-bold fs-6">
                                    <i class="ti ti-weight me-1 text-muted"></i> Bobot: <?= $k->bobot ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <?php if(empty($subs)): ?>
                        <div class="d-flex flex-column align-items-center justify-content-center py-5 bg-light bg-opacity-25">
                            <div class="avatar avatar-xl bg-white shadow-sm mb-3 rounded p-2">
                                <i class="ti ti-list-details fs-1 text-muted"></i>
                            </div>
                            <h5 class="text-muted fw-bold mb-1">Belum ada parameter.</h5>
                            <p class="text-muted">Input nilai dilakukan manual (Angka).</p>
                            <button class="btn btn-outline-primary fw-bold" onclick="resetFormSubWithId('<?= $k->id_kriteria ?>')" data-bs-toggle="modal" data-bs-target="#modalSub">
                                <i class="ti ti-plus me-1"></i> Buat Parameter Baru
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-uppercase fs-6 fw-bolder text-dark" width="45%">
                                            <i class="ti ti-tag me-1 text-muted"></i> Nama Parameter
                                        </th>
                                        <th class="text-center py-3 text-uppercase fs-6 fw-bolder text-dark" width="15%">
                                            <i class="ti ti-123 me-1 text-muted"></i> Nilai
                                        </th>
                                        <th class="text-center py-3 text-uppercase fs-6 fw-bolder text-dark" width="25%">
                                            <i class="ti ti-chart-bar me-1 text-muted"></i> Visual Level
                                        </th>
                                        <th class="text-end pe-4 py-3 text-uppercase fs-6 fw-bolder text-dark" width="15%">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($subs as $s): 
                                        // Visualisasi Progress Bar
                                        $percent = ($s->nilai / 5) * 100;
                                        if($s->nilai >= 5) $bar_color = 'bg-success';
                                        elseif($s->nilai >= 4) $bar_color = 'bg-primary';
                                        elseif($s->nilai >= 3) $bar_color = 'bg-info';
                                        else $bar_color = 'bg-warning';
                                    ?>
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <span class="fw-bolder fs-6 text-heading"><?= $s->nama_sub ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-label-primary fs-6 fw-bolder px-3 rounded-pill font-monospace">
                                                <?= $s->nilai ?>
                                            </span>
                                        </td>
                                        <td class="text-center px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <small class="fw-bold text-muted w-25">Level <?= $s->nilai ?></small>
                                                <div class="progress w-100 shadow-sm" style="height: 8px; border-radius: 10px; background-color: rgba(100,100,100,0.1);">
                                                    <div class="progress-bar <?= $bar_color ?>" role="progressbar" style="width: <?= $percent ?>%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-icon btn-label-warning waves-effect" 
                                                        onclick="editSub('<?= $s->id_sub ?>', '<?= $k->id_kriteria ?>', '<?= $s->nama_sub ?>', '<?= $s->nilai ?>')"
                                                        data-bs-toggle="modal" data-bs-target="#modalSub" title="Edit Data">
                                                    <i class="ti ti-pencil fs-5"></i>
                                                </button>
                                                <a href="<?= base_url('subkriteria/hapus/'.$s->id_sub) ?>" 
                                                   class="btn btn-icon btn-label-danger waves-effect"
                                                   onclick="return confirm('Yakin ingin menghapus parameter ini?')" title="Hapus Data">
                                                    <i class="ti ti-trash fs-5"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade" id="modalSub" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow-lg" action="<?= base_url('subkriteria/simpan') ?>" method="post">
            <div class="modal-header bg-primary py-4">
                <h4 class="modal-title text-white fw-bold" id="modalTitleSub">
                    <i class="ti ti-settings me-2"></i> Tambah Parameter
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id_sub" id="id_sub">
                
                <div class="mb-4">
                    <label class="form-label fw-bold fs-6 text-dark">Kriteria Induk</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-category fs-5"></i></span>
                        <select name="id_kriteria" id="id_kriteria" class="form-select form-select-lg" required>
                            <option value="">-- Pilih Kriteria --</option>
                            <?php foreach($kriteria_list as $k): ?>
                                <option value="<?= $k->id_kriteria ?>"><?= $k->kode_kriteria ?> - <?= $k->nama_kriteria ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold fs-6 text-dark">Nama Parameter (Label)</label>
                        <input type="text" name="nama_sub" id="nama_sub" class="form-control form-control-lg" placeholder="Contoh: Sangat Baik" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold fs-6 text-dark">Nilai Bobot</label>
                        <input type="number" step="0.1" name="nilai" id="nilai" class="form-control form-control-lg" placeholder="1-5" required>
                    </div>
                </div>
                
                <div class="alert alert-primary d-flex align-items-center p-3 mt-4 mb-0 rounded-3" role="alert">
                    <i class="ti ti-info-circle me-3 fs-3"></i>
                    <div>
                        <div class="fw-bold">Informasi</div>
                        <div class="small">Nilai bobot ini akan dikonversi menjadi angka saat perhitungan metode TOPSIS.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer p-3 bg-light">
                <button type="button" class="btn btn-label-secondary btn-lg fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-lg fw-bold px-5">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
function editSub(id, id_krit, nama, nilai) {
    document.getElementById('modalTitleSub').innerHTML = '<i class="ti ti-pencil me-2"></i> Edit Parameter';
    document.getElementById('id_sub').value = id;
    document.getElementById('id_kriteria').value = id_krit;
    document.getElementById('nama_sub').value = nama;
    document.getElementById('nilai').value = nilai;
}

function resetFormSub() {
    document.getElementById('modalTitleSub').innerHTML = '<i class="ti ti-plus me-2"></i> Tambah Parameter';
    document.getElementById('id_sub').value = '';
    document.getElementById('id_kriteria').value = '';
    document.getElementById('nama_sub').value = '';
    document.getElementById('nilai').value = '';
}

function resetFormSubWithId(id_krit) {
    resetFormSub();
    document.getElementById('id_kriteria').value = id_krit;
}
</script>