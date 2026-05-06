<style>
    /* --- CSS DASAR (LIGHT MODE) --- */
    .table-responsive { border-radius: 8px; }
    
    /* Border Avatar Default (Putih) */
    .avatar img, .avatar .avatar-initial {
        border: 3px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* --- LOGIKA DARK MODE (Vuexy Style) --- */
    html.dark-style .card {
        background-color: #2f3349 !important;
        color: #b6bee3 !important;
    }
    html.dark-style .card-header {
        border-bottom-color: #434968 !important;
        background-color: #2f3349 !important;
    }
    html.dark-style .bg-light {
        background-color: #3f445e !important;
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
    /* Ubah border avatar jadi gelap saat dark mode */
    html.dark-style .avatar img, 
    html.dark-style .avatar .avatar-initial {
        border-color: #2f3349 !important;
    }
</style>

<div class="card mb-4 bg-transparent shadow-none">
    <div class="card-body p-0 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 fw-bolder text-primary">Manajemen Pengguna</h3>
            <p class="text-muted mb-0" style="font-size: 1.1rem;">Kelola akun administrator dan tim penilai.</p>
        </div>
        <button type="button" class="btn btn-primary btn-lg waves-effect waves-light shadow-sm fw-bold" 
                data-bs-toggle="modal" data-bs-target="#modalUser" onclick="resetFormUser()">
            <i class="ti ti-user-plus me-2 fs-4"></i> Tambah User Baru
        </button>
    </div>
</div>

<?= $this->session->flashdata('pesan'); ?>

<div class="card border-0 shadow-lg overflow-hidden">
    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-users me-2 text-primary"></i>Daftar Pengguna Aktif</h5>
        <span class="badge bg-label-primary rounded-pill px-3">Total: <?= count($users) ?></span>
    </div>
    
    <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase fs-6 fw-bolder text-dark" width="5%">#</th>
                    <th class="py-3 text-uppercase fs-6 fw-bolder text-dark text-center" width="10%">Foto</th>
                    <th class="py-3 text-uppercase fs-6 fw-bolder text-dark" width="30%">Nama Lengkap</th>
                    <th class="py-3 text-uppercase fs-6 fw-bolder text-dark" width="20%">Username</th>
                    <th class="py-3 text-uppercase fs-6 fw-bolder text-dark" width="15%">Role Akses</th>
                    <th class="text-end pe-4 py-3 text-uppercase fs-6 fw-bolder text-dark" width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($users as $u): 
                    // Tentukan Warna & Ikon Role
                    $is_admin = ($u->role == 'admin');
                    $bg_color = $is_admin ? 'primary' : 'success'; 
                    $icon_role = $is_admin ? 'ti-shield-lock' : 'ti-edit';
                    
                    // Path Foto Fisik
                    $path_foto = './assets/img/avatars/uploads/' . $u->foto;
                ?>
                <tr>
                    <td class="ps-4 text-muted"><?= $no++ ?></td>
                    
                    <td class="text-center">
                        <div class="avatar avatar-md mx-auto">
                            <?php if (!empty($u->foto) && file_exists($path_foto)): ?>
                                <img src="<?= base_url('assets/img/avatars/uploads/' . $u->foto) ?>" alt="Avatar" class="h-auto rounded-circle" style="object-fit: cover;">
                            <?php else: ?>
                                <span class="avatar-initial rounded-circle bg-label-<?= $bg_color ?> fw-bold">
                                    <?= substr($u->nama_lengkap, 0, 2) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </td>

                    <td>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark"><?= $u->nama_lengkap ?></h6>
                            <small class="text-muted font-monospace">ID: #<?= str_pad($u->id_user, 3, '0', STR_PAD_LEFT) ?></small>
                        </div>
                    </td>

                    <td>
                        <span class="fw-medium text-heading">
                            <i class="ti ti-user me-1 text-muted"></i> <?= $u->username ?>
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-label-<?= $bg_color ?> px-3 py-2 rounded-pill text-uppercase fs-tiny fw-bold">
                            <i class="ti <?= $icon_role ?> me-1"></i> <?= $u->role ?>
                        </span>
                    </td>

                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-icon btn-label-warning waves-effect" 
                                    onclick="editUser('<?= $u->id_user ?>', '<?= $u->username ?>', '<?= $u->nama_lengkap ?>', '<?= $u->role ?>')"
                                    data-bs-toggle="modal" data-bs-target="#modalUser" title="Edit User">
                                <i class="ti ti-pencil fs-5"></i>
                            </button>
                            
                            <?php if($u->id_user != $this->session->userdata('id_user')): ?>
                                <a href="<?= base_url('user/hapus/'.$u->id_user) ?>" 
                                   class="btn btn-icon btn-label-danger waves-effect" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus user <?= $u->nama_lengkap ?>?')" 
                                   title="Hapus User">
                                    <i class="ti ti-trash fs-5"></i>
                                </a>
                            <?php else: ?>
                                <button class="btn btn-icon btn-label-secondary cursor-not-allowed" title="Anda sedang login" disabled>
                                    <i class="ti ti-lock fs-5"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow-lg" action="<?= base_url('user/simpan') ?>" method="post">
            <div class="modal-header bg-primary py-4">
                <h4 class="modal-title text-white fw-bold" id="modalTitleUser">
                    <i class="ti ti-user-plus me-2"></i> Tambah User
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id_user" id="id_user">
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-id"></i></span>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control form-control-lg" placeholder="Contoh: Budi Santoso" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark">Username Login</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" name="username" id="username" class="form-control" placeholder="user123" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark">Role Akses</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-shield"></i></span>
                            <select name="role" id="role" class="form-select">
                                <option value="penilai">Penilai</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold text-dark">Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Biarkan kosong jika tidak ubah password">
                        <span class="input-group-text cursor-pointer"><i class="ti ti-lock"></i></span>
                    </div>
                    <div class="alert alert-primary d-flex align-items-center mt-3 p-2 rounded" role="alert">
                        <i class="ti ti-info-circle me-2"></i>
                        <div class="small" id="passHelp">Default password untuk user baru: <b>123456</b></div>
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
function editUser(id, user, nama, role) {
    document.getElementById('modalTitleUser').innerHTML = '<i class="ti ti-pencil me-2"></i> Edit User';
    document.getElementById('id_user').value = id;
    document.getElementById('username').value = user;
    document.getElementById('nama_lengkap').value = nama;
    document.getElementById('role').value = role;
    document.getElementById('password').value = ''; 
    document.getElementById('passHelp').innerHTML = 'Kosongkan jika tidak ingin mengubah password.';
}

function resetFormUser() {
    document.getElementById('modalTitleUser').innerHTML = '<i class="ti ti-user-plus me-2"></i> Tambah User';
    document.getElementById('id_user').value = '';
    document.getElementById('username').value = '';
    document.getElementById('nama_lengkap').value = '';
    document.getElementById('role').value = 'penilai';
    document.getElementById('password').value = '';
    document.getElementById('passHelp').innerHTML = 'Wajib diisi untuk user baru (Default: 123456).';
}
</script>