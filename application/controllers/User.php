<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        $data['judul_halaman'] = "Manajemen User";
        $data['users'] = $this->db->get('users')->result();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('user/index', $data);
        $this->load->view('layout/footer');
    }

    public function simpan() {
        $id = $this->input->post('id_user');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        // Cek Username Duplikat (Kecuali punya sendiri saat edit)
        $this->db->where('username', $username);
        if($id) {
            $this->db->where('id_user !=', $id);
        }
        $cek = $this->db->get('users')->num_rows();

        if($cek > 0) {
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible" role="alert">
                    Username <b>'.$username.'</b> sudah digunakan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            ');
            redirect('user');
            return;
        }

        $data = [
            'username'     => $username,
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'role'         => $this->input->post('role')
        ];

        // Password hanya diupdate jika diisi
        if (!empty($password)) {
            $data['password'] = md5($password);
        }

        if ($id) {
            $this->db->where('id_user', $id);
            $this->db->update('users', $data);
            
            // Jika user penilai, update juga nama di tabel penilai (opsional, untuk sinkronisasi)
            if($data['role'] == 'penilai') {
               // Logika sinkronisasi nama penilai bisa ditambahkan di sini jika perlu
            }
            
            $msg = "Data user berhasil diperbarui.";
        } else {
            // Wajib isi password saat tambah baru
            if (empty($password)) {
                $data['password'] = md5('123456'); // Default password jika lupa isi
            }
            $this->db->insert('users', $data);
            
            // Jika Penilai baru, otomatis tambah ke tabel master 'penilai'
            if($data['role'] == 'penilai') {
                $this->db->insert('penilai', ['nama_penilai' => $data['nama_lengkap']]);
            }
            
            $msg = "User baru berhasil ditambahkan.";
        }

        $this->session->set_flashdata('pesan', '
            <div class="alert alert-success alert-dismissible" role="alert">
                <i class="ti ti-check me-1"></i> '.$msg.'
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        ');
        redirect('user');
    }

    public function hapus($id) {
        // Cegah hapus diri sendiri
        if($id == $this->session->userdata('id_user')) {
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-warning" role="alert">Anda tidak bisa menghapus akun sendiri!</div>
            ');
            redirect('user');
            return;
        }

        // Ambil data user untuk cek role sebelum hapus
        $user = $this->db->get_where('users', ['id_user' => $id])->row();
        
        if($user) {
            // Hapus user
            $this->db->where('id_user', $id);
            $this->db->delete('users');
            
            // Jika role penilai, hapus juga di tabel penilai master?
            // Hati-hati, ini bisa menghapus data penilaian. 
            // Disarankan manual atau soft delete jika di sistem nyata.
            // Untuk skripsi/tugas, biarkan saja atau hapus manual di Data Master Penilai.
        }

        $this->session->set_flashdata('pesan', '
            <div class="alert alert-success" role="alert">Data user berhasil dihapus.</div>
        ');
        redirect('user');
    }
}