<style>
    /* --- CSS DASAR (LIGHT MODE) --- */
    .table-responsive {
        border-radius: 8px;
    }
    
    /* --- LOGIKA DARK MODE (Vuexy Style) --- */
    /* Mengubah warna background card utama */
    html.dark-style .card {
        background-color: #2f3349 !important;
        color: #b6bee3 !important;
    }
    /* Mengubah warna garis bawah header card */
    html.dark-style .card-header {
        border-bottom-color: #434968 !important;
        background-color: #2f3349 !important; /* Timpa bg-white */
    }
    /* Mengubah warna teks & border tabel */
    html.dark-style .table {
        color: #b6bee3 !important;
        border-color: #434968 !important;
    }
    html.dark-style .table thead th {
        background-color: #3f445e !important;
        color: #d0d2d6 !important;
        border-bottom: 1px solid #434968 !important;
    }
    html.dark-style .table-hover tbody tr:hover td {
        background-color: #363b54 !important;
    }
    /* Mengubah input form menjadi gelap */
    html.dark-style .form-control, 
    html.dark-style .input-group-text {
        background-color: #25293c !important;
        border-color: #434968 !important;
        color: #d0d2d6 !important;
    }
    /* Mengubah modal pop-up menjadi gelap */
    html.dark-style .modal-content {
        background-color: #2f3349 !important;
        color: #b6bee3 !important;
    }
    html.dark-style .modal-header {
        border-bottom-color: #434968 !important;
    }
    html.dark-style .modal-footer {
        border-top-color: #434968 !important;
        background-color: #2f3349 !important;
    }
    html.dark-style .text-dark {
        color: #d0d2d6 !important;
    }
    /* Membalik warna tombol close (X) di modal agar terlihat putih */
    html.dark-style .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    /* Avatar Empty State */
    html.dark-style .avatar.bg-label-secondary {
        background-color: #434968 !important;
        color: #b6bee3 !important;
    }
</style>

<div class="card mb-4 bg-transparent shadow-none">
    <div class="card-body p-0 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 fw-bolder text-primary">Data Alternatif</h3>
            <p class="text-muted mb-0" style="font-size: 1.1rem;">Kelola kandidat atau opsi yang akan dinilai dalam SPK.</p>
        </div>
        <button type="button" class="btn btn-primary btn-lg waves-effect waves-light shadow-sm fw-bold" 
                data-bs-toggle="modal" data-bs-target="#modalAlternatif" onclick="resetFormAlternatif()">
            <i class="ti ti-plus me-2 fs-4"></i> Tambah Alternatif
        </button>
    </div>
</div>

<?= $this->session->flashdata('pesan'); ?>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-list-details me-2 text-primary"></i>Daftar Kandidat</h5>
        <span class="badge bg-label-primary rounded-pill px-3"><?= count($alternatif) ?> Data</span>
    </div>
    
    <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase fs-6 fw-bolder text-dark" width="20%">Kode</th>
                    <th class="py-3 text-uppercase fs-6 fw-bolder text-dark">Nama Alternatif</th>
                    <th class="text-end pe-4 py-3 text-uppercase fs-6 fw-bolder text-dark" width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($alternatif)): ?>
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <div class="avatar avatar-xl bg-label-secondary mb-3 rounded p-2 mx-auto">
                                <i class="ti ti-database-off fs-1"></i>
                            </div>
                            <h6 class="mb-1">Belum ada data alternatif.</h6>
                            <small>Klik tombol tambah untuk memulai.</small>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php 
                        // Array warna acak untuk avatar agar lebih menarik
                        $colors = ['primary', 'success', 'warning', 'info', 'danger', 'secondary'];
                        $i = 0;
                        
                        foreach($alternatif as $a): 
                            $theme = $colors[$i % count($colors)];
                            $i++;
                    ?>
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-label-primary fs-6 px-3 rounded-pill fw-bold font-monospace">
                                <?= $a->kode_alternatif ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-<?= $theme ?> fw-bold">
                                        <?= strtoupper(substr($a->nama_alternatif, 0, 1)) ?>
                                    </span>
                                </div>
                                <span class="fw-bold text-heading fs-6"><?= $a->nama_alternatif ?></span>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-icon btn-label-warning waves-effect" 
                                        onclick="editAlternatif('<?= $a->id_alternatif ?>', '<?= $a->kode_alternatif ?>', '<?= $a->nama_alternatif ?>')"
                                        data-bs-toggle="modal" data-bs-target="#modalAlternatif" title="Edit">
                                    <i class="ti ti-pencil fs-5"></i>
                                </button>
                                
                                <a href="<?= base_url('alternatif/hapus/'.$a->id_alternatif) ?>" 
                                   class="btn btn-icon btn-label-danger waves-effect" 
                                   onclick="return confirm('PERHATIAN: Menghapus alternatif <?= $a->nama_alternatif ?> akan menghapus semua nilai penilaian terkait. Lanjutkan?')"
                                   title="Hapus">
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

<div class="modal fade" id="modalAlternatif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow-lg" action="<?= base_url('alternatif/simpan') ?>" method="post">
            <div class="modal-header bg-primary py-4">
                <h4 class="modal-title text-white fw-bold" id="modalTitleAlt">
                    <i class="ti ti-cube me-2"></i> Tambah Alternatif
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id_alternatif" id="id_alternatif_form">
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Kode Alternatif <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-barcode"></i></span>
                        <input type="text" name="kode" id="kode_alternatif_form" class="form-control form-control-lg" placeholder="Contoh: A1" required>
                    </div>
                    <div class="form-text text-danger">* Kode harus unik (tidak boleh sama).</div>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold">Nama Alternatif</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-id"></i></span>
                        <input type="text" name="nama" id="nama_alternatif_form" class="form-control form-control-lg" placeholder="Contoh: Tik Tok / Instagram" required>
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
// Fungsi Edit
function editAlternatif(id, kode, nama) {
    document.getElementById('modalTitleAlt').innerHTML = '<i class="ti ti-pencil me-2"></i> Edit Alternatif';
    document.getElementById('id_alternatif_form').value = id;
    document.getElementById('kode_alternatif_form').value = kode;
    document.getElementById('nama_alternatif_form').value = nama;
}

// Fungsi Reset Form
function resetFormAlternatif() {
    document.getElementById('modalTitleAlt').innerHTML = '<i class="ti ti-plus me-2"></i> Tambah Alternatif';
    document.getElementById('id_alternatif_form').value = '';
    document.getElementById('kode_alternatif_form').value = '';
    document.getElementById('nama_alternatif_form').value = '';
}
</script>