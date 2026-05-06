<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(['session', 'upload']);

        // Cek Login
        if ($this->session->userdata('status') != 'login') {
            redirect('auth');
        }
    }

    public function index() {
        $data['judul_halaman'] = "Edit Profil Saya";
        
        // Ambil data user yang sedang login berdasarkan ID di session
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->db->get_where('users', ['id_user' => $id_user])->row();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('profil/index', $data);
        $this->load->view('layout/footer');
    }

    public function update() {
        $id_user = $this->session->userdata('id_user');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $username = $this->input->post('username');
        $password_baru = $this->input->post('password_baru');

        // Data dasar yang akan diupdate
        $data_update = [
            'nama_lengkap' => $nama_lengkap,
            'username'     => $username
        ];

        // 1. Cek jika ada ubah password
        if (!empty($password_baru)) {
            $data_update['password'] = md5($password_baru);
        }

        // 2. Proses Upload Foto
        // Cek apakah ada file yang diupload di input 'foto_profil'
        if (!empty($_FILES['foto_profil']['name'])) {
            
            // Konfigurasi Upload
            $config['upload_path']   = './assets/img/avatars/uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 5024; // 5MB
            $config['file_name']     = 'profil-' . $id_user . '-' . time(); // Nama file unik
            $config['overwrite']     = true;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_profil')) {
                // Jika berhasil upload
                $upload_data = $this->upload->data();
                $foto_baru = $upload_data['file_name'];

                // Hapus foto lama jika ada (Optional, agar hemat storage)
                $user_lama = $this->db->get_where('users', ['id_user' => $id_user])->row();
                if ($user_lama->foto != null && file_exists('./assets/img/avatars/uploads/' . $user_lama->foto)) {
                    unlink('./assets/img/avatars/uploads/' . $user_lama->foto);
                }

                // Masukkan nama foto baru ke array update
                $data_update['foto'] = $foto_baru;
                
                // Update foto di session agar navbar langsung berubah
                $this->session->set_userdata('foto', $foto_baru);

            } else {
                // Jika gagal upload, tampilkan error
                $error_msg = $this->upload->display_errors();
                $this->session->set_flashdata('pesan', '
                    <div class="alert alert-danger" role="alert">
                        <i class="ti ti-alert-circle me-1"></i> Gagal Upload Foto: '.$error_msg.'
                    </div>
                ');
                redirect('profil');
                return; // Stop proses
            }
        }

        // 3. Eksekusi Update Database
        $this->db->where('id_user', $id_user);
        if ($this->db->update('users', $data_update)) {
            
            // Update session nama jika berubah
            $this->session->set_userdata('nama', $nama_lengkap);
            $this->session->set_userdata('username', $username);

            $this->session->set_flashdata('pesan', '
                <div class="alert alert-success" role="alert">
                    <i class="ti ti-check me-1"></i> Profil berhasil diperbarui!
                </div>
            ');
        } else {
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger" role="alert">
                    <i class="ti ti-alert-circle me-1"></i> Gagal memperbarui profil database.
                </div>
            ');
        }

        redirect('profil');
    }
}