<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spk_model extends CI_Model {

    public function get_penilai() {
        return $this->db->get('penilai')->result();
    }

    public function get_alternatif() {
        return $this->db->get('alternatif')->result();
    }

    public function get_kriteria() {
        return $this->db->get('kriteria')->result();
    }

    // Mengambil nilai mentah berdasarkan penilai
    public function get_penilaian_by_penilai($id_penilai) {
        $this->db->select('penilaian.*, alternatif.kode_alternatif, alternatif.nama_alternatif, kriteria.kode_kriteria, kriteria.jenis, kriteria.bobot');
        $this->db->from('penilaian');
        $this->db->join('alternatif', 'alternatif.id_alternatif = penilaian.id_alternatif');
        $this->db->join('kriteria', 'kriteria.id_kriteria = penilaian.id_kriteria');
        $this->db->where('penilaian.id_penilai', $id_penilai);
        return $this->db->get()->result();
    }

    // --- LOGIC TOPSIS ---
    public function hitung_topsis($id_penilai) {
        $data_nilai = $this->get_penilaian_by_penilai($id_penilai);
        $kriteria = $this->get_kriteria();
        $alternatif = $this->get_alternatif();
        
        // 1. Susun Matriks Keputusan (X)
        $matriks_x = [];
        foreach ($data_nilai as $row) {
            $matriks_x[$row->id_alternatif][$row->id_kriteria] = $row->nilai;
        }

        // 2. Normalisasi Matriks (R)
        // Pembagi = sqrt(sum(x^2))
        $pembagi = [];
        foreach ($kriteria as $k) {
            $sum_sq = 0;
            foreach ($alternatif as $a) {
                $val = isset($matriks_x[$a->id_alternatif][$k->id_kriteria]) ? $matriks_x[$a->id_alternatif][$k->id_kriteria] : 0;
                $sum_sq += pow($val, 2);
            }
            $pembagi[$k->id_kriteria] = sqrt($sum_sq);
        }

        $matriks_r = [];
        foreach ($alternatif as $a) {
            foreach ($kriteria as $k) {
                $val = isset($matriks_x[$a->id_alternatif][$k->id_kriteria]) ? $matriks_x[$a->id_alternatif][$k->id_kriteria] : 0;
                $matriks_r[$a->id_alternatif][$k->id_kriteria] = ($pembagi[$k->id_kriteria] != 0) ? $val / $pembagi[$k->id_kriteria] : 0;
            }
        }

        // 3. Matriks Terbobot (Y)
        $matriks_y = [];
        foreach ($alternatif as $a) {
            foreach ($kriteria as $k) {
                $matriks_y[$a->id_alternatif][$k->id_kriteria] = $matriks_r[$a->id_alternatif][$k->id_kriteria] * $k->bobot;
            }
        }

        // 4. Solusi Ideal Positif (A+) dan Negatif (A-)
        $a_plus = [];
        $a_min = [];
        foreach ($kriteria as $k) {
            $col_values = [];
            foreach ($alternatif as $a) {
                $col_values[] = $matriks_y[$a->id_alternatif][$k->id_kriteria];
            }
            
            if ($k->jenis == 'Benefit') {
                $a_plus[$k->id_kriteria] = max($col_values);
                $a_min[$k->id_kriteria] = min($col_values);
            } else { // Cost
                $a_plus[$k->id_kriteria] = min($col_values);
                $a_min[$k->id_kriteria] = max($col_values);
            }
        }

        // 5. Jarak Solusi (D+ dan D-)
        $d_plus = [];
        $d_min = [];
        $preferensi = []; // Nilai V

        foreach ($alternatif as $a) {
            $sum_d_plus = 0;
            $sum_d_min = 0;
            foreach ($kriteria as $k) {
                $sum_d_plus += pow($matriks_y[$a->id_alternatif][$k->id_kriteria] - $a_plus[$k->id_kriteria], 2);
                $sum_d_min += pow($matriks_y[$a->id_alternatif][$k->id_kriteria] - $a_min[$k->id_kriteria], 2);
            }
            $d_plus[$a->id_alternatif] = sqrt($sum_d_plus);
            $d_min[$a->id_alternatif] = sqrt($sum_d_min);

            // 6. Nilai Preferensi (V)
            $denom = $d_min[$a->id_alternatif] + $d_plus[$a->id_alternatif];
            $v = ($denom != 0) ? $d_min[$a->id_alternatif] / $denom : 0;
            
            $preferensi[] = [
                'id_alternatif' => $a->id_alternatif,
                'nama' => $a->nama_alternatif,
                'nilai_v' => $v
            ];
        }

        // Sort berdasarkan Nilai V tertinggi (Ranking)
        usort($preferensi, function($a, $b) {
            return $b['nilai_v'] <=> $a['nilai_v'];
        });

        return $preferensi;
    }

    // --- LOGIC BORDA ---
    public function hitung_borda() {
        $penilai = $this->get_penilai();
        $alternatif = $this->get_alternatif();
        $total_poin_borda = [];

        // Inisialisasi poin 0
        foreach ($alternatif as $a) {
            $total_poin_borda[$a->id_alternatif] = [
                'nama' => $a->nama_alternatif,
                'poin' => 0,
                'detail_rank' => []
            ];
        }

        $jumlah_kandidat = count($alternatif);

        // Loop setiap penilai, ambil hasil TOPSIS-nya
        foreach ($penilai as $p) {
            $hasil_topsis = $this->hitung_topsis($p->id_penilai);
            
            // Pemberian Poin Borda: Rank 1 = N poin, Rank 2 = N-1 poin, dst.
            foreach ($hasil_topsis as $rank => $data) {
                // $rank dimulai dari 0 (array index), jadi Poin = jumlah_kandidat - $rank
                $poin = $jumlah_kandidat - $rank;
                
                $id = $data['id_alternatif'];
                $total_poin_borda[$id]['poin'] += $poin;
                $total_poin_borda[$id]['detail_rank'][$p->nama_penilai] = "Rank " . ($rank + 1) . " ($poin pts)";
            }
        }

        // Sort Hasil Akhir Borda
        usort($total_poin_borda, function($a, $b) {
            return $b['poin'] <=> $a['poin'];
        });

        return $total_poin_borda;
    }
}