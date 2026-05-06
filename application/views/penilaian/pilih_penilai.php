<style>
    /* --- CSS DASAR (LIGHT MODE) --- */
    .card-penilai {
        transition: all 0.3s ease-in-out;
        border: none;
        overflow: hidden;
        position: relative;
        background-color: #fff; /* Default Putih */
    }
    .card-penilai:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    /* Dekorasi Atas (Gradient) */
    .card-decoration {
        height: 80px;
        width: 100%;
        background: linear-gradient(45deg, #f0f2f5, #e1e4e8); /* Gradient Abu Terang */
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
    }
    
    .avatar-profile {
        position: relative;
        z-index: 1;
        margin-top: 30px;
    }

    /* Border Avatar (Default Putih agar seolah memotong kartu) */
    .avatar-border {
        border: 4px solid #fff; 
    }

    /* --- LOGIKA DARK MODE (Vuexy Style) --- */
    html.dark-style .card-penilai {
        background-color: #2f3349 !important; /* Warna Kartu Gelap */
        color: #b6bee3 !important;
    }
    
    /* Ubah Gradient Dekorasi jadi Gelap */
    html.dark-style .card-decoration {
        background: linear-gradient(45deg, #323954, #25293c) !important;
    }
    
    /* Ubah Border Avatar jadi Gelap (Agar menyatu dengan kartu) */
    html.dark-style .avatar-border {
        border-color: #2f3349 !important;
    }

    /* Ubah warna teks judul */
    html.dark-style .text-dark {
        color: #d0d2d6 !important;
    }
    
    /* Ubah warna teks deskripsi */
    html.dark-style .text-muted {
        color: #7983bb !important;
    }
</style>

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Penilaian /</span> Pilih Penilai
</h4>

<div class="row g-4"> 
    <?php 
    // Array warna untuk variasi avatar
    $colors = ['primary', 'success', 'warning', 'info', 'danger', 'secondary'];
    $i = 0;
    
    foreach($penilai as $p): 
        // Pilih warna secara bergantian
        $theme = $colors[$i % count($colors)];
        $i++;
    ?>
    <div class="col-md-6 col-lg-4">
        <div class="card card-penilai shadow-sm h-100">
            <div class="card-decoration"></div>
            
            <div class="card-body text-center p-4">
                <div class="avatar avatar-xl mb-3 mx-auto avatar-profile">
                    <span class="avatar-initial rounded-circle bg-label-<?= $theme ?> fw-bold shadow-sm avatar-border fs-3">
                        <?= strtoupper(substr($p->nama_penilai, 0, 1)) ?>
                    </span>
                </div>
                
                <h5 class="card-title fw-bold text-dark mb-1"><?= $p->nama_penilai ?></h5>
                <p class="card-text text-muted mb-4 small">
                    <i class="ti ti-id-badge-2 me-1"></i> <?= $p->deskripsi ?? 'Tim Penilai SPK' ?>
                </p>

                <a href="<?= base_url('penilaian/input/'.$p->id_penilai) ?>" class="btn btn-outline-<?= $theme ?> w-100 fw-bold waves-effect">
                    <i class="ti ti-pencil-plus me-2"></i> Input Penilaian
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>