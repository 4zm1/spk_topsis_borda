<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        // Load library form validation atau session jika diperlukan
        $this->load->library('session');
        if ($this->session->userdata('status') != 'login') {
        redirect('auth');
    }
    }

    // ------------------------------------------------------------------------
    // HALAMAN UTAMA: PILIH PENILAI
    // ------------------------------------------------------------------------
    public function index() {
        $role = $this->session->userdata('role');
        $id_penilai_session = $this->session->userdata('id_penilai');

        // LOGIKA ROLE:
        // Jika Penilai, langsung lempar ke halaman input diri sendiri
        if ($role == 'penilai') {
            redirect('penilaian/input/' . $id_penilai_session);
            return;
        }

        // Jika Admin, tampilkan halaman pilih penilai
        $data['judul_halaman'] = "Input Penilaian";
        $data['penilai'] = $this->db->get('penilai')->result();
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('penilaian/pilih_penilai', $data);
        $this->load->view('layout/footer');
    }

    // ------------------------------------------------------------------------
    // HALAMAN FORM MATRIX (INPUT NILAI)
    // ------------------------------------------------------------------------
    public function input($id_penilai) {
        $data['judul_halaman'] = "Form Penilaian";
        
        // 1. Ambil Data Penilai Terpilih
        $data['penilai_terpilih'] = $this->db->get_where('penilai', ['id_penilai' => $id_penilai])->row();
        
        if (!$data['penilai_terpilih']) {
            show_404(); // Tampilkan error jika ID penilai ngawur
        }

        // 2. Ambil Data Master (Alternatif & Kriteria)
        // Order by kode agar urutan rapi (A1, A2, dst / C1, C2, dst)
        $this->db->order_by('kode_alternatif', 'ASC');
        $data['alternatif'] = $this->db->get('alternatif')->result();
        
        $this->db->order_by('kode_kriteria', 'ASC');
        $data['kriteria'] = $this->db->get('kriteria')->result();

        // 3. [PENTING] Ambil Data Sub Kriteria untuk Dropdown
        // Kita ambil semua sub kriteria, lalu urutkan nilai terbesar ke terkecil
        $sub_query = $this->db->order_by('nilai', 'DESC')->get('sub_kriteria')->result();
        
        // Mapping Sub Kriteria berdasarkan ID Kriteria
        // Format array: $data['sub_kriteria_map'][id_kriteria] = [daftar_subnya]
        $data['sub_kriteria_map'] = [];
        foreach ($sub_query as $s) {
            $data['sub_kriteria_map'][$s->id_kriteria][] = $s;
        }

        // 4. Ambil Nilai Existing (Jika user mau mengedit nilai yang sudah ada)
        $existing = $this->db->get_where('penilaian', ['id_penilai' => $id_penilai])->result_array();
        
        // Mapping nilai lama ke array [id_alternatif][id_kriteria] = nilai
        $data['nilai_existing'] = [];
        foreach($existing as $row) {
            $data['nilai_existing'][$row['id_alternatif']][$row['id_kriteria']] = $row['nilai'];
        }

        // 5. Load Views
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('penilaian/form_matrix', $data); // Pastikan nama file view sesuai
        $this->load->view('layout/footer');
    }

    // ------------------------------------------------------------------------
    // PROSES SIMPAN KE DATABASE
    // ------------------------------------------------------------------------
    public function simpan() {
        // Tangkap ID Penilai
        $id_penilai = $this->input->post('id_penilai');
        
        // Tangkap Array Nilai (Format: name="nilai[id_alt][id_kriteria]")
        $nilai_input = $this->input->post('nilai'); 

        // Validasi sederhana
        if (empty($id_penilai) || empty($nilai_input)) {
            redirect('penilaian');
            return;
        }

        // 1. Bersihkan nilai lama untuk penilai ini (Reset)
        // Ini cara paling aman agar tidak ada duplikasi data atau konflik update
        $this->db->where('id_penilai', $id_penilai);
        $this->db->delete('penilaian');

        // 2. Siapkan Data Batch untuk Insert
        $batch_data = [];
        foreach($nilai_input as $id_alt => $kriteria_data) {
            foreach($kriteria_data as $id_kriteria => $nilai) {
                // Pastikan nilai tidak kosong/null
                if($nilai !== '' && $nilai !== null) {
                    $batch_data[] = [
                        'id_penilai'    => $id_penilai,
                        'id_alternatif' => $id_alt,
                        'id_kriteria'   => $id_kriteria,
                        'nilai'         => $nilai
                    ];
                }
            }
        }

        // 3. Insert Batch (Sekali query untuk banyak data -> Efisien)
        if(!empty($batch_data)) {
            $this->db->insert_batch('penilaian', $batch_data);
            
            // Set Flashdata untuk notifikasi sukses (Opsional)
            // $this->session->set_flashdata('success', 'Data penilaian berhasil disimpan!');
        }

        // 4. Redirect kembali ke halaman pilih penilai
        redirect('penilaian'); 
    }
}