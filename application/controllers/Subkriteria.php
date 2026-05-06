<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subkriteria extends CI_Controller {

    public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');

    // 1. Cek Login
    if ($this->session->userdata('status') != 'login') {
        redirect('auth');
    }

    // 2. Cek Role (Hanya Admin yang boleh masuk sini)
    if ($this->session->userdata('role') != 'admin') {
        // Jika Penilai coba masuk, tendang ke Dashboard
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.location.href='".base_url('dashboard')."';</script>";
        exit;
    }
}

    public function index() {
        $data['judul_halaman'] = "Data Sub Kriteria";
        
        // 1. Ambil semua Kriteria (Parent)
        $this->db->order_by('kode_kriteria', 'ASC');
        $kriteria = $this->db->get('kriteria')->result();

        // 2. Ambil semua Sub Kriteria (Child)
        $this->db->order_by('nilai', 'DESC');
        $sub_kriteria = $this->db->get('sub_kriteria')->result();

        // 3. Mapping: Masukkan Sub Kriteria ke dalam Kriteria masing-masing
        $grouped_data = [];
        foreach ($kriteria as $k) {
            $grouped_data[$k->id_kriteria] = [
                'info' => $k,
                'subs' => []
            ];
        }

        foreach ($sub_kriteria as $s) {
            if (isset($grouped_data[$s->id_kriteria])) {
                $grouped_data[$s->id_kriteria]['subs'][] = $s;
            }
        }

        $data['grouped_sub'] = $grouped_data;
        $data['kriteria_list'] = $kriteria; // Untuk dropdown modal tambah

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('sub_kriteria/index', $data);
        $this->load->view('layout/footer');
    }

    public function simpan() {
        $id = $this->input->post('id_sub');
        $data = [
            'id_kriteria' => $this->input->post('id_kriteria'),
            'nama_sub'    => $this->input->post('nama_sub'),
            'nilai'       => $this->input->post('nilai')
        ];

        if ($id) {
            $this->db->where('id_sub', $id);
            $this->db->update('sub_kriteria', $data);
        } else {
            $this->db->insert('sub_kriteria', $data);
        }
        redirect('subkriteria');
    }

    public function hapus($id) {
        if ($id) {
            $this->db->where('id_sub', $id);
            $this->db->delete('sub_kriteria');
        }
        redirect('subkriteria');
    }
}