<div class="layout-page">
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            
            <div class="navbar-nav align-items-center">
                <div class="nav-item navbar-search-wrapper mb-0">
                    <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                        <i class="ti ti-search ti-md me-2"></i>
                        <span class="d-none d-md-inline-block text-muted">Cari Data (Ctrl+/)</span>
                    </a>
                </div>
            </div>
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                
                <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class="ti ti-md"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                <span class="align-middle"><i class="ti ti-sun me-2"></i>Light</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                <span class="align-middle"><i class="ti ti-moon me-2"></i>Dark</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                <span class="align-middle"><i class="ti ti-device-desktop-analytics me-2"></i>System</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <?php 
                                // Logika PHP: Cek Foto Profil
                                $foto = $this->session->userdata('foto');
                                $nama = $this->session->userdata('nama');
                                $path_foto = './assets/img/avatars/uploads/' . $foto;

                                if (!empty($foto) && file_exists($path_foto)) { 
                            ?>
                                <img src="<?= base_url('assets/img/avatars/uploads/' . $foto) ?>" alt class="h-auto rounded-circle border border-2 border-white shadow-sm" style="object-fit: cover;" />
                            <?php } else { ?>
                                <span class="avatar-initial rounded-circle bg-label-primary fw-bold">
                                    <?= substr($nama, 0, 2) ?>
                                </span>
                            <?php } ?>
                        </div>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('profil') ?>">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <?php if (!empty($foto) && file_exists($path_foto)) { ?>
                                                <img src="<?= base_url('assets/img/avatars/uploads/' . $foto) ?>" alt class="h-auto rounded-circle" style="object-fit: cover;" />
                                            <?php } else { ?>
                                                <span class="avatar-initial rounded-circle bg-label-primary fw-bold">
                                                    <?= substr($nama, 0, 2) ?>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">
                                            <?= $this->session->userdata('nama') ?? 'User' ?>
                                        </span>
                                        <small class="text-muted text-capitalize">
                                            <?= $this->session->userdata('role') ?? 'Guest' ?>
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><div class="dropdown-divider"></div></li>
                        
                        <li>
                            <a class="dropdown-item" href="<?= base_url('profil') ?>">
                                <i class="ti ti-user-check me-2 ti-sm"></i>
                                <span class="align-middle">Edit Profil</span>
                            </a>
                        </li>
                        
                        <li><div class="dropdown-divider"></div></li>
                        
                        <li>
                            <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                                <i class="ti ti-logout me-2 ti-sm"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
                </ul>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">