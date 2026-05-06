<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alternatif extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

        // Proteksi: Hanya Admin yang boleh akses
        if ($this->session->userdata('status') != 'login') {
            redirect('auth');
        }
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
    }

    public function index() {
        $data['judul_halaman'] = "Data Alternatif";
        $data['alternatif'] = $this->db->get('alternatif')->result();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('alternatif/index', $data);
        $this->load->view('layout/footer');
    }

    public function simpan() {
        $id = $this->input->post('id_alternatif');
        $kode = $this->input->post('kode');
        $nama = $this->input->post('nama');

        // --- VALIDASI KODE UNIK (CODE UNIT) ---
        $this->db->where('kode_alternatif', $kode);
        if ($id) {
            // Jika Edit: Cek kode sama TAPI bukan milik ID ini
            $this->db->where('id_alternatif !=', $id);
        }
        $cek = $this->db->get('alternatif')->num_rows();

        if ($cek > 0) {
            // GAGAL: Kode sudah ada
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <h5 class="alert-heading mb-1"><i class="ti ti-alert-circle me-1"></i> Gagal Menyimpan!</h5>
                    Kode Alternatif <b>'.$kode.'</b> sudah digunakan. Silakan gunakan kode lain.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('alternatif');
            return; // Stop proses
        }
        // -------------------------------------

        $data = [
            'kode_alternatif' => $kode,
            'nama_alternatif' => $nama
        ];

        if ($id) {
            $this->db->where('id_alternatif', $id);
            $this->db->update('alternatif', $data);
            $msg = "Alternatif berhasil diperbarui.";
        } else {
            $this->db->insert('alternatif', $data);
            $msg = "Alternatif baru berhasil ditambahkan.";
        }

        // SUKSES
        $this->session->set_flashdata('pesan', '
            <div class="alert alert-success alert-dismissible" role="alert">
                <i class="ti ti-check me-1"></i> '.$msg.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');

        redirect('alternatif');
    }

    public function hapus($id) {
        if (!isset($id)) show_404();

        // Hapus juga nilai terkait agar data bersih
        $this->db->where('id_alternatif', $id);
        $this->db->delete('penilaian');

        // Hapus Alternatif
        $this->db->where('id_alternatif', $id);
        $this->db->delete('alternatif');

        $this->session->set_flashdata('pesan', '
            <div class="alert alert-success alert-dismissible" role="alert">
                <i class="ti ti-trash me-1"></i> Data Alternatif berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');

        redirect('alternatif');
    }
}