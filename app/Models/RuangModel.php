<?php

namespace App\Models;

use CodeIgniter\Model;

class RuangModel extends Model
{
    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';
    protected $allowedFields = ['kode_ruangan', 'nama_ruangan', 'id_gedung'];

    public function getRuang($kode = false)
    {
        if ($kode == false) {
            return $this->db->table('ruangan')->select('*')->join('gedung', 'gedung.id_gedung = ruangan.id_gedung')->get()->getResultArray();
        }
        return $this->db->table('ruangan')->select('*')->where('kode_ruangan', $kode)->join('gedung', 'gedung.id_gedung = ruangan.id_gedung')->get()->getRowArray();
    }
}
