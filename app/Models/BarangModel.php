<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['nama_barang', 'merek', 'tahun_perolehan', 'id_kategori'];

    public function getBarang($id = false)
    {
        if ($id == false) {
            return $this->db->table('barang')->select('*')->join('kategori', 'kategori.id_kategori = barang.id_kategori')->get()->getResultArray();
        }
        return $this->db->table('barang')->select('*')->where('id_barang', $id)->join('kategori', 'kategori.id_kategori = barang.id_kategori')->get()->getRowArray();
    }
}
