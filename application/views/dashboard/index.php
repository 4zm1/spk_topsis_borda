<style>
    .card-stat {
        transition: all 0.3s ease-in-out;
        border: none;
        overflow: hidden;
        position: relative;
    }
    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    .card-stat .avatar-icon {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
    }
    .bg-gradient-primary { background: linear-gradient(45deg, #7367F0, #9e95f5); }
    .bg-gradient-info    { background: linear-gradient(45deg, #00CFE8, #4ce4f5); }
    .bg-gradient-warning { background: linear-gradient(45deg, #FF9F43, #ffc080); }
    .bg-gradient-success { background: linear-gradient(45deg, #28C76F, #5ddb95); }
    
    .winner-card {
        background: linear-gradient(135deg, #ffffff 0%, #f4f6f8 100%);
        border-top: 5px solid #7367F0;
    }
</style>

<div class="row mb-4">
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card card-stat h-100 bg-gradient-primary text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="text-white text-opacity-75 text-uppercase fw-bold mb-1" style="font-size: 0.75rem;">Total Kriteria</h6>
                        <h2 class="display-6 text-white mb-0 fw-bold"><?= $total_kriteria ?></h2>
                    </div>
                    <div class="avatar p-2 rounded avatar-icon">
                        <i class="ti ti-chart-pie-2 ti-md text-white"></i>
                    </div>
                </div>
                <small class="text-white text-opacity-75"><i class="ti ti-arrow-up"></i> Parameter Aktif</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card card-stat h-100 bg-gradient-info text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="text-white text-opacity-75 text-uppercase fw-bold mb-1" style="font-size: 0.75rem;">Alternatif</h6>
                        <h2 class="display-6 text-white mb-0 fw-bold"><?= $total_alternatif ?></h2>
                    </div>
                    <div class="avatar p-2 rounded avatar-icon">
                        <i class="ti ti-users ti-md text-white"></i>
                    </div>
                </div>
                <small class="text-white text-opacity-75"><i class="ti ti-check"></i> Kandidat Media</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card card-stat h-100 bg-gradient-warning text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="text-white text-opacity-75 text-uppercase fw-bold mb-1" style="font-size: 0.75rem;">Tim Penilai</h6>
                        <h2 class="display-6 text-white mb-0 fw-bold"><?= $total_penilai ?></h2>
                    </div>
                    <div class="avatar p-2 rounded avatar-icon">
                        <i class="ti ti-edit ti-md text-white"></i>
                    </div>
                </div>
                <small class="text-white text-opacity-75"><i class="ti ti-user"></i> User Terdaftar</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card card-stat h-100 bg-gradient-success text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="text-white text-opacity-75 text-uppercase fw-bold mb-1" style="font-size: 0.75rem;">Progress Input</h6>
                        <h2 class="display-6 text-white mb-0 fw-bold"><?= $penilai_aktif ?> <span class="fs-6 text-opacity-75">/ <?= $total_penilai ?></span></h2>
                    </div>
                    <div class="avatar p-2 rounded avatar-icon">
                        <i class="ti ti-activity ti-md text-white"></i>
                    </div>
                </div>
                <div class="progress bg-white bg-opacity-25" style="height: 6px; border-radius: 10px;">
                    <?php $persen = ($total_penilai > 0) ? ($penilai_aktif / $total_penilai) * 100 : 0; ?>
                    <div class="progress-bar bg-white" role="progressbar" style="width: <?= $persen ?>%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-8 col-12 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-transparent">
                <div>
                    <h5 class="card-title mb-0 fw-bold text-primary"><i class="ti ti-trophy me-2"></i>Ranking Keputusan (Borda)</h5>
                    <small class="text-muted">Visualisasi skor akhir dari agregasi penilai</small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-label-primary p-1 px-2">
                        <i class="ti ti-refresh me-1"></i> Live Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="chartBorda"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-12 mb-4">
        <div class="card h-100 winner-card shadow-lg text-center card-stat">
            <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                <div class="mb-4 position-relative">
                    <div class="avatar avatar-xl p-1 border border-5 border-primary rounded-circle bg-white">
                        <span class="avatar-initial rounded-circle bg-gradient-primary text-white">
                            <i class="ti ti-crown ti-xl fs-1"></i>
                        </span>
                    </div>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-white shadow-sm">
                        #1
                    </span>
                </div>
                
                <h6 class="text-uppercase text-muted fw-bold letter-spacing-1 mb-1">Rekomendasi Utama</h6>
                <h3 class="text-primary fw-extrabold mb-1"><?= $top_winner ?></h3>
                <p class="text-muted mb-4 small">Alternatif Terbaik Berdasarkan Perhitungan</p>

                <div class="d-grid gap-2 w-100 mt-auto">
                    <a href="<?= base_url('spk') ?>" class="btn btn-primary fw-bold shadow-sm">
                        <i class="ti ti-file-analytics me-2"></i> Lihat Detail Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0 fw-bold"><i class="ti ti-scale me-2"></i>Bobot Kriteria</h5>
            </div>
            <div class="card-body">
                <div id="chartDonut"></div>
                <div class="text-center mt-3">
                    <small class="text-muted">Proporsi prioritas dalam sistem SPK</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-6 col-12 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-transparent d-flex justify-content-between">
                <div>
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-chart-bar me-2"></i>Peta Nilai Preferensi</h5>
                    <small class="text-muted">Perbandingan konsistensi antar penilai</small>
                </div>
            </div>
            <div class="card-body">
                <div id="chartComparison"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    
    // --- 1. CHART BORDA ---
    var optionsBorda = {
        series: [{ name: 'Total Poin', data: <?= $borda_scores ?> }],
        chart: { type: 'bar', height: 350, toolbar: { show: false }, fontFamily: 'Public Sans, sans-serif' },
        plotOptions: { bar: { borderRadius: 8, horizontal: true, distributed: true, barHeight: '65%' } },
        colors: ['#7367F0', '#28C76F', '#FF9F43', '#EA5455', '#00CFE8'],
        dataLabels: { 
            enabled: true, 
            textAnchor: 'start', 
            style: { colors: ['#fff'] },
            formatter: function (val, opt) { return opt.w.globals.labels[opt.dataPointIndex] + ": " + val }
        },
        xaxis: { categories: <?= $borda_labels ?> },
        yaxis: { labels: { show: false } },
        grid: { show: false },
        legend: { show: false }
    };
    new ApexCharts(document.querySelector("#chartBorda"), optionsBorda).render();

    // --- 2. CHART DONUT ---
    var optionsDonut = {
        series: <?= $donut_series ?>, labels: <?= $donut_labels ?>,
        chart: { type: 'donut', height: 320, fontFamily: 'Public Sans, sans-serif' },
        colors: ['#7367F0', '#28C76F', '#FF9F43', '#EA5455'],
        plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Bobot', formatter: function (w) { return w.globals.seriesTotals.reduce((a, b) => a + b, 0) } } } } } },
        legend: { position: 'bottom', markers: { radius: 12 } }
    };
    new ApexCharts(document.querySelector("#chartDonut"), optionsDonut).render();

    // --- 3. CHART COMPARISON ---
    var optionsComp = {
        series: <?= $comparison_series ?>,
        chart: { type: 'bar', height: 350, toolbar: { show: false }, fontFamily: 'Public Sans, sans-serif' },
        plotOptions: { bar: { horizontal: false, columnWidth: '55%', borderRadius: 4 } },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        xaxis: { categories: <?= $comparison_labels ?>, title: { text: 'Kode Alternatif' } },
        colors: ['#7367F0', '#FF9F43', '#28C76F'],
        legend: { position: 'top' },
        fill: { opacity: 1 }
    };
    new ApexCharts(document.querySelector("#chartComparison"), optionsComp).render();
});
</script>