<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        // Cek login jika perlu
        if ($this->session->userdata('status') != 'login') {
            exit(json_encode([])); // Return kosong jika belum login
        }
    }

    public function index() {
        $keyword = $this->input->get('q', TRUE);
        $results = [];

        if (strlen($keyword) >= 2) { // Minimal 2 karakter baru mencari
            
            // 1. CARI DI MENU (Navigasi Cepat)
            $menus = [
                ['label' => 'Dashboard', 'url' => base_url('dashboard'), 'icon' => 'ti-smart-home'],
                ['label' => 'Data Kriteria', 'url' => base_url('kriteria'), 'icon' => 'ti-list'],
                ['label' => 'Data Sub Kriteria', 'url' => base_url('subkriteria'), 'icon' => 'ti-list-details'],
                ['label' => 'Data Alternatif', 'url' => base_url('alternatif'), 'icon' => 'ti-users'],
                ['label' => 'Input Penilaian', 'url' => base_url('penilaian'), 'icon' => 'ti-pencil'],
                ['label' => 'Hasil Perhitungan', 'url' => base_url('spk'), 'icon' => 'ti-chart-bar'],
                ['label' => 'Manajemen User', 'url' => base_url('user'), 'icon' => 'ti-user-check'],
            ];

            foreach ($menus as $m) {
                if (stripos($m['label'], $keyword) !== false) {
                    $results[] = [
                        'category' => 'Menu',
                        'title' => $m['label'],
                        'url' => $m['url'],
                        'icon' => $m['icon']
                    ];
                }
            }

            // 2. CARI DI TABEL ALTERNATIF
            $this->db->like('nama_alternatif', $keyword);
            $this->db->or_like('kode_alternatif', $keyword);
            $query_alt = $this->db->get('alternatif')->result();
            
            foreach ($query_alt as $row) {
                $results[] = [
                    'category' => 'Alternatif',
                    'title' => $row->nama_alternatif . ' (' . $row->kode_alternatif . ')',
                    'url' => base_url('alternatif'), // Arahkan ke index alternatif
                    'icon' => 'ti-id'
                ];
            }

            // 3. CARI DI TABEL KRITERIA
            $this->db->like('nama_kriteria', $keyword);
            $query_krit = $this->db->get('kriteria')->result();

            foreach ($query_krit as $row) {
                $results[] = [
                    'category' => 'Kriteria',
                    'title' => $row->nama_kriteria,
                    'url' => base_url('kriteria'),
                    'icon' => 'ti-tag'
                ];
            }
        }

        // Return JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    }
}