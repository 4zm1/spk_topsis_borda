<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    
    <div class="app-brand demo">
        <a href="<?= base_url('dashboard') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold">SPK Topsis</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        
        <li class="menu-item <?= ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'active' : '' ?>">
            <a href="<?= base_url('dashboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div>Dashboard Utama</div>
            </a>
        </li>

        <?php if($this->session->userdata('role') == 'admin'): ?>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Data Master (Admin)</span>
            </li>

            <li class="menu-item <?= ($this->uri->segment(1) == 'kriteria') ? 'active' : '' ?>">
                <a href="<?= base_url('kriteria') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-chart-pie-2"></i>
                    <div>Data Kriteria</div>
                </a>
            </li>

            <li class="menu-item <?= ($this->uri->segment(1) == 'subkriteria') ? 'active' : '' ?>">
                <a href="<?= base_url('subkriteria') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-list-check"></i>
                    <div>Data Sub Kriteria</div>
                </a>
            </li>

            <li class="menu-item <?= ($this->uri->segment(1) == 'alternatif') ? 'active' : '' ?>">
                <a href="<?= base_url('alternatif') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div>Data Alternatif</div>
                </a>
            </li>
        <?php endif; ?>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Proses</span>
        </li>

        <li class="menu-item <?= ($this->uri->segment(1) == 'penilaian') ? 'active' : '' ?>">
            <a href="<?= base_url('penilaian') ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-edit"></i>
                <div>Input Penilaian</div>
            </a>
        </li>

        <?php if($this->session->userdata('role') == 'admin'): ?>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Laporan</span>
            </li>

            <li class="menu-item <?= ($this->uri->segment(1) == 'spk') ? 'active' : '' ?>">
                <a href="<?= base_url('spk') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-report-analytics"></i>
                    <div>Hasil Perhitungan</div>
                </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(1) == 'user') ? 'active' : '' ?>">
                <a href="<?= base_url('user') ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-users-plus"></i> <div>Manajemen User</div>
                </a>
            </li>
        <?php endif; ?>
        
        <!-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Akun</span>
        </li> -->
        <!-- <li class="menu-item">
            <a href="<?= base_url('auth/logout') ?>" class="menu-link text-danger" onclick="return confirm('Keluar dari sistem?')">
                <i class="menu-icon tf-icons ti ti-logout"></i>
                <div>Logout (<?= ucfirst($this->session->userdata('role')) ?>)</div>
            </a>
        </li> -->
    </ul>
</aside>