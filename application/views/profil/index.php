<div class="card mb-4 bg-transparent shadow-none">
    <div class="card-body p-0">
        <h3 class="mb-1 fw-bolder text-primary">Pengaturan Akun</h3>
        <p class="text-muted mb-0" style="font-size: 1.1rem;">Kelola informasi profil dan keamanan akun Anda.</p>
    </div>
</div>

<?= $this->session->flashdata('pesan'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4 border-0 shadow-lg">
            <h5 class="card-header bg-white border-bottom py-3 fw-bold">
                <i class="ti ti-user-circle me-2 text-primary"></i>Detail Profil
            </h5>
            
            <?= form_open_multipart('profil/update', ['id' => 'formAccountSettings']); ?>
            
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    
                    <?php 
                        // Cek apakah user punya foto, jika tidak pakai default
                        $foto_path = base_url('assets/img/avatars/default.png'); // Ganti dengan path foto default Anda jika ada
                        if($user->foto != null && file_exists('./assets/img/avatars/uploads/'.$user->foto)) {
                            $foto_path = base_url('assets/img/avatars/uploads/'.$user->foto);
                        } elseif ($user->foto != null) {
                             // Fallback jika file di db ada tapi fisik tidak ada
                            $foto_path = base_url('assets/img/avatars/uploads/'.$user->foto);
                        } else {
                            // Jika null, gunakan avatar inisial (pakai trik CSS atau gambar placeholder)
                            $foto_path = base_url('assets/img/avatars/1.png'); // Placeholder dari template Vuexy
                        }
                    ?>
                    <img src="<?= $foto_path ?>" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded border border-3 border-primary shadow-sm p-1" id="uploadedAvatar" style="object-fit: cover;"/>
                    
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-2 mb-3 fw-bold" tabindex="0">
                            <span class="d-none d-sm-block"><i class="ti ti-upload me-1"></i> Upload Foto Baru</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" name="foto_profil" />
                        </label>
                        <button type="button" class="btn btn-label-secondary account-image-reset mb-3 fw-bold">
                            <i class="ti ti-refresh me-1"></i> Reset
                        </button>
                        <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 5MB.</div>
                    </div>
                </div>
            </div>
            
            <hr class="my-0" />
            
            <div class="card-body pt-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-id"></i></span>
                            <input type="text" class="form-control form-control-lg" id="nama_lengkap" name="nama_lengkap" value="<?= $user->nama_lengkap ?>" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Username</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" class="form-control form-control-lg" id="username" name="username" value="<?= $user->username ?>" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Role Akses</label>
                        <input type="text" class="form-control form-control-lg bg-light" value="<?= ucfirst($user->role) ?>" readonly disabled />
                        <div class="form-text"><i class="ti ti-info-circle"></i> Role tidak dapat diubah sendiri.</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-primary">Ganti Password (Opsional)</label>
                        <div class="input-group input-group-merge">
                            <input type="password" class="form-control form-control-lg border-primary" id="password_baru" name="password_baru" placeholder="Biarkan kosong jika tidak diganti" />
                            <span class="input-group-text border-primary cursor-pointer"><i class="ti ti-lock"></i></span>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold me-2 px-4">
                        <i class="ti ti-device-floppy me-2"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-label-secondary btn-lg fw-bold">Batal</a>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const borderColor = '#d9dee3'; // Default border color
    let accountUserImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input'),
      resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
      const resetImage = accountUserImage.src;
      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
        }
      };
      resetFileInput.onclick = () => {
        fileInput.value = '';
        accountUserImage.src = resetImage;
      };
    }
  })();
});
</script>