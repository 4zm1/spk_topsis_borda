<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function index() {
        if ($this->session->userdata('status') == 'login') {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function process() {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $password_md5 = md5($password);

        // Cek ke Tabel Users
        $this->db->where('username', $username);
        $this->db->where('password', $password_md5);
        $user = $this->db->get('users')->row();

        if ($user) {
            // Mapping ID User ke ID Penilai
            // Admin (ID 1) -> Bukan penilai
            // Penilai 1 (ID 2) -> ID Penilai 1
            // Penilai 2 (ID 3) -> ID Penilai 2
            // Penilai 3 (ID 4) -> ID Penilai 3
            // Rumus sederhana: id_penilai = id_user - 1 (Jika urutan insert sesuai SQL di atas)
            
            $id_penilai_terkait = ($user->role == 'penilai') ? ($user->id_user - 1) : 0;

            $data_session = [
                'id_user'  => $user->id_user,
                'username' => $user->username,
                'nama'     => $user->nama_lengkap,
                'role'     => $user->role,          // Simpan Role
                'id_penilai'=> $id_penilai_terkait, // ID untuk input nilai
                'status'   => 'login'
            ];
            $this->session->set_userdata($data_session);
            
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                    <i class="ti ti-alert-circle me-2"></i> Username atau Password salah!
                </div>
            ');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}