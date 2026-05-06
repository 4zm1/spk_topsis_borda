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
        background-color: #3f445e !important; /* Header Tabel */
    }
    html.dark-style .table {
        color: #b6bee3 !important;
        border-color: #434968 !important;
    }
    html.dark-style .table-hover tbody tr:hover td {
        background-color: #363b54 !important;
    }
    html.dark-style .table thead th {
        background-color: #3f445e !important;
        color: #d0d2d6 !important;
        border-bottom: 1px solid #434968 !important;
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
        background-color: #2f3349 !important;
        border-top-color: #434968 !important;
    }
    html.dark-style .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    /* Empty State Icon Background */
    html.dark-style .ti-database-off {
        color: #7983bb !important;
    }
</style>

<div class="card mb-4 bg-transparent shadow-none">
    <div class="card-body p-0 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 fw-bolder text-primary">Master Kriteria</h3>
            <p class="text-muted mb-0" style="font-size: 1.1rem;">Kelola atribut penilaian dan bobot prioritas.</p>
        </div>
        <button type="button" class="btn btn-primary btn-lg waves-effect waves-light shadow-sm fw-bold" 
                data-bs-toggle="modal" data-bs-target="#modalKriteria" onclick="resetFormKriteria()">
            <i class="ti ti-plus me-2 fs-4"></i> Tambah Kriteria
        </button>
    </div>
</div>

<?= $this->session->flashdata('pesan'); ?>

<div class="card border-0 shadow-lg overflow-hidden">
    <div class="card-header bg-white py-3 d-flex align-items-center border-bottom">
        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-list me-2 text-primary"></i>Daftar Kriteria</h5>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase fs-6 fw-bolder text-dark" width="15%">Kode</th>
                    <th class="py-3 text-uppercase fs-6 fw-bolder text-dark">Nama Kriteria</th>
                    <th class="py-3 text-uppercase fs-6 fw-bolder text-dark" width="15%">Bobot</th>
                    <th class="py-3 text-uppercase fs-6 fw-bolder text-dark" width="15%">Jenis Atribut</th>
                    <th class="text-end pe-4 py-3 text-uppercase fs-6 fw-bolder text-dark" width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($kriteria)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="avatar avatar-xl bg-label-secondary mb-3 rounded p-2 mx-auto">
                                <i class="ti ti-database-off fs-1"></i>
                            </div>
                            <h6 class="mb-1">Belum ada data kriteria.</h6>
                            <small>Klik tombol tambah untuk memulai.</small>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($kriteria as $k): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="avatar avatar-sm rounded bg-label-primary d-flex align-items-center justify-content-center">
                                <span class="fw-bolder font-monospace"><?= $k->kode_kriteria ?></span>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-heading fs-6"><?= $k->nama_kriteria ?></span>
                        </td>
                        <td>
                            <span class="badge bg-label-warning fs-6 px-3 rounded-pill fw-bold">
                                <?= $k->bobot ?>
                            </span>
                        </td>
                        <td>
                            <?php if($k->jenis == 'Benefit'): ?>
                                <span class="badge bg-label-success fs-tiny fw-bold text-uppercase px-3">
                                    <i class="ti ti-trending-up me-1"></i> Benefit
                                </span>
                            <?php else: ?>
                                <span class="badge bg-label-danger fs-tiny fw-bold text-uppercase px-3">
                                    <i class="ti ti-trending-down me-1"></i> Cost
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-icon btn-label-warning waves-effect" 
                                        onclick="editKriteria('<?= $k->id_kriteria ?>', '<?= $k->kode_kriteria ?>', '<?= $k->nama_kriteria ?>', '<?= $k->bobot ?>', '<?= $k->jenis ?>')"
                                        data-bs-toggle="modal" data-bs-target="#modalKriteria" title="Edit">
                                    <i class="ti ti-pencil fs-5"></i>
                                </button>
                                <a href="<?= base_url('kriteria/hapus/'.$k->id_kriteria) ?>" 
                                   class="btn btn-icon btn-label-danger waves-effect" 
                                   onclick="return confirm('Hapus Kriteria <?= $k->nama_kriteria ?>? Data penilaian terkait juga akan terhapus.')" title="Hapus">
                                    <i class="ti ti-trash fs-5"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalKriteria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow-lg" action="<?= base_url('kriteria/simpan') ?>" method="post">
            <div class="modal-header bg-primary py-4">
                <h4 class="modal-title text-white fw-bold" id="modalTitleKriteria">
                    <i class="ti ti-settings me-2"></i> Tambah Kriteria
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id_kriteria" id="id_kriteria_form">
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Kode Kriteria <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-barcode"></i></span>
                        <input type="text" name="kode" id="kode_kriteria_form" class="form-control form-control-lg" placeholder="C1" required>
                    </div>
                    <div class="form-text text-danger">* Kode tidak boleh sama dengan yang sudah ada.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Nama Kriteria</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-tag"></i></span>
                        <input type="text" name="nama" id="nama_kriteria_form" class="form-control form-control-lg" placeholder="Contoh: Harga / Kualitas" required>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark">Bobot (Angka)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-weight"></i></span>
                            <input type="number" name="bobot" id="bobot_form" class="form-control form-control-lg" placeholder="1-5" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark">Jenis Atribut</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-chart-arrows"></i></span>
                            <select name="jenis" id="jenis_form" class="form-select form-select-lg">
                                <option value="Benefit">Benefit (Untung)</option>
                                <option value="Cost">Cost (Biaya)</option>
                            </select>
                        </div>
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
function editKriteria(id, kode, nama, bobot, jenis) {
    document.getElementById('modalTitleKriteria').innerHTML = '<i class="ti ti-pencil me-2"></i> Edit Kriteria';
    document.getElementById('id_kriteria_form').value = id;
    document.getElementById('kode_kriteria_form').value = kode;
    document.getElementById('nama_kriteria_form').value = nama;
    document.getElementById('bobot_form').value = bobot;
    document.getElementById('jenis_form').value = jenis;
}

function resetFormKriteria() {
    document.getElementById('modalTitleKriteria').innerHTML = '<i class="ti ti-plus me-2"></i> Tambah Kriteria';
    document.getElementById('id_kriteria_form').value = '';
    document.getElementById('kode_kriteria_form').value = '';
    document.getElementById('nama_kriteria_form').value = '';
    document.getElementById('bobot_form').value = '';
}
</script>