<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Spk_model');
        if ($this->session->userdata('status') != 'login') {
        redirect('auth');
    }
        // Cek login session di sini jika ada
    }

    public function index() {
        $data['judul_halaman'] = "Dashboard Eksekutif";

        // --- 1. DATA KARTU STATISTIK ---
        $data['total_kriteria']   = $this->db->count_all('kriteria');
        $data['total_alternatif'] = $this->db->count_all('alternatif');
        $data['total_penilai']    = $this->db->count_all('penilai');
        
        // Hitung penilai yang sudah input (distinct id_penilai di tabel penilaian)
        $this->db->select('id_penilai');
        $this->db->distinct();
        $query_aktif = $this->db->get('penilaian');
        $data['penilai_aktif'] = $query_aktif->num_rows();


        // --- 2. DATA GRAFIK 1: SKOR BORDA (BAR CHART) ---
        $hasil_borda = $this->Spk_model->hitung_borda();
        
        $borda_labels = [];
        $borda_scores = [];
        
        if (!empty($hasil_borda)) {
            // Ambil Top 5 atau Semua
            foreach($hasil_borda as $row) {
                $borda_labels[] = $row['nama'];
                $borda_scores[] = $row['poin'];
            }
            $data['top_winner'] = $hasil_borda[0]['nama'];
        } else {
            $data['top_winner'] = "Belum Ada Data";
        }
        
        $data['borda_labels'] = json_encode($borda_labels);
        $data['borda_scores'] = json_encode($borda_scores);


        // --- 3. DATA GRAFIK 2: BOBOT KRITERIA (DONUT CHART) ---
        $kriteria = $this->db->get('kriteria')->result();
        $krit_labels = [];
        $krit_bobot = [];
        
        foreach($kriteria as $k) {
            $krit_labels[] = $k->nama_kriteria;
            $krit_bobot[]  = (int) $k->bobot;
        }
        $data['donut_labels'] = json_encode($krit_labels);
        $data['donut_series'] = json_encode($krit_bobot);


        // --- 4. DATA GRAFIK 3: PERBANDINGAN PENILAI (STACKED/GROUPED BAR) ---
        $penilai_list = $this->db->get('penilai')->result();
        $comparison_series = [];
        $alt_labels = [];

        // Ambil label alternatif (sumbu X)
        $alternatif_master = $this->db->order_by('kode_alternatif', 'ASC')->get('alternatif')->result();
        foreach($alternatif_master as $a) {
            $alt_labels[] = $a->kode_alternatif; // A1, A2, dst
        }

        // Loop setiap penilai untuk membuat series data
        foreach($penilai_list as $p) {
            $hasil_topsis = $this->Spk_model->hitung_topsis($p->id_penilai);
            
            // Kita harus mapping nilai V agar urut sesuai alternatif_master (A1, A2, A3...)
            // Karena hasil topsis biasanya urut ranking
            $nilai_v_urut = [];
            
            foreach($alternatif_master as $alt_m) {
                $nilai_ketemu = 0; // Default 0 jika belum dinilai
                foreach($hasil_topsis as $ht) {
                    if($ht['id_alternatif'] == $alt_m->id_alternatif) {
                        $nilai_ketemu = number_format($ht['nilai_v'], 3);
                        break;
                    }
                }
                $nilai_v_urut[] = $nilai_ketemu;
            }

            $comparison_series[] = [
                'name' => $p->nama_penilai,
                'data' => $nilai_v_urut
            ];
        }

        $data['comparison_series'] = json_encode($comparison_series);
        $data['comparison_labels'] = json_encode($alt_labels);


        // Load Views
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('layout/footer');
    }
}