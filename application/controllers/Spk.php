<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // 1. Load Library & Database Wajib
        $this->load->database();
        $this->load->library('session');
        
        // 2. LOAD MODEL SEKALI SAJA DI SINI
        $this->load->model('Spk_model');

        // 3. Cek Login (Security)
        if ($this->session->userdata('status') != 'login') {
            redirect('auth');
        }

        // 4. Cek Role (Hanya Admin yang boleh lihat Hasil Akhir)
        if ($this->session->userdata('role') != 'admin') {
            echo "<script>alert('Akses Ditolak! Halaman ini hanya untuk Admin.'); window.location.href='".base_url('dashboard')."';</script>";
            exit;
        }
    }

    public function index() {
        $data['judul_halaman'] = "Hasil Analisis SPK";
        
        // Ambil data penilai
        $data['penilai'] = $this->Spk_model->get_penilai();
        
        // Ambil hasil TOPSIS per Penilai
        $data['hasil_per_penilai'] = [];
        if(!empty($data['penilai'])) {
            foreach ($data['penilai'] as $p) {
                $data['hasil_per_penilai'][$p->nama_penilai] = $this->Spk_model->hitung_topsis($p->id_penilai);
            }
        }

        // Hitung Hasil Akhir (Borda)
        $data['hasil_borda'] = $this->Spk_model->hitung_borda();

        // Load Views (Template Vuexy)
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('spk_view', $data);
        $this->load->view('layout/footer');
    }

    public function cetak() {
        // Tidak perlu load model lagi, karena sudah ada di __construct
        
        $data['judul_halaman'] = "Laporan Hasil Akhir";
        
        // 1. Ambil Data
        $data['penilai'] = $this->Spk_model->get_penilai();
        
        $data['hasil_per_penilai'] = [];
        if(!empty($data['penilai'])) {
            foreach ($data['penilai'] as $p) {
                $data['hasil_per_penilai'][$p->nama_penilai] = $this->Spk_model->hitung_topsis($p->id_penilai);
            }
        }
        
        // Data Utama untuk Laporan
        $data['hasil_borda'] = $this->Spk_model->hitung_borda();

        // 2. Load View Khusus Cetak (Tanpa Header/Sidebar/Footer)
        $this->load->view('spk/cetak', $data);
    }
}