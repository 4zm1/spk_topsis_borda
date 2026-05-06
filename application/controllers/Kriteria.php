<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {

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
        $data['judul_halaman'] = "Data Kriteria";
        
        // Ambil data kriteria
        $this->db->order_by('kode_kriteria', 'ASC');
        $data['kriteria'] = $this->db->get('kriteria')->result();

        // Load Views
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('kriteria/index', $data);
        $this->load->view('layout/footer');
    }

    public function simpan() {
    $id = $this->input->post('id_kriteria');
    $kode = $this->input->post('kode');
    
    // --- VALIDASI DUPLIKAT ---
    $this->db->where('kode_kriteria', $kode);
    if ($id) {
        // Jika Edit: Cek kode sama TAPI bukan punya ID ini
        $this->db->where('id_kriteria !=', $id);
    }
    $cek = $this->db->get('kriteria')->num_rows();

    if ($cek > 0) {
        // GAGAL: Data sudah ada
        $this->session->set_flashdata('pesan', '
            <div class="alert alert-danger alert-dismissible" role="alert">
                <h5 class="alert-heading mb-1"><i class="ti ti-alert-circle me-1"></i> Gagal Menyimpan!</h5>
                Kode Kriteria <b>'.$kode.'</b> sudah digunakan. Silakan gunakan kode lain.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
        redirect('kriteria');
        return; // Stop proses
    }
    // -------------------------

    $data = [
        'kode_kriteria' => $kode,
        'nama_kriteria' => $this->input->post('nama'),
        'bobot'         => $this->input->post('bobot'),
        'jenis'         => $this->input->post('jenis')
    ];

    if ($id) {
        $this->db->where('id_kriteria', $id);
        $this->db->update('kriteria', $data);
        $msg = "Data berhasil diperbarui.";
    } else {
        $this->db->insert('kriteria', $data);
        $msg = "Data berhasil ditambahkan.";
    }

    // SUKSES
    $this->session->set_flashdata('pesan', '
        <div class="alert alert-success alert-dismissible" role="alert">
            <i class="ti ti-check me-1"></i> '.$msg.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    ');

    redirect('kriteria');
}
public function hapus($id) {
        if (!isset($id)) show_404();

        // 1. Hapus data terkait di tabel Sub Kriteria (Anak data)
        $this->db->where('id_kriteria', $id);
        $this->db->delete('sub_kriteria');

        // 2. Hapus data terkait di tabel Penilaian (Anak data)
        $this->db->where('id_kriteria', $id);
        $this->db->delete('penilaian');

        // 3. Baru hapus Kriteria Utama
        $this->db->where('id_kriteria', $id);
        $this->db->delete('kriteria');

        // 4. Tampilkan Notifikasi Sukses
        $this->session->set_flashdata('pesan', '
            <div class="alert alert-success alert-dismissible" role="alert">
                <i class="ti ti-check me-1"></i> Data Kriteria dan data terkait berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');

        redirect('kriteria');
    }
}