<?php

namespace App\Models;

use CodeIgniter\Model;

class AsetMasukModel extends Model
{
    protected $table = 'aset_masuk';
    protected $primaryKey = 'id_aset_masuk';
    protected $allowedFields = ['id_barang', 'jumlah', 'tanggal_masuk', 'keterangan', 'user_penginput'];

    public function getAsetMasuk()
    {
        return $this->db->table('aset_masuk')->select('*')->orderBy('tanggal_masuk', 'Desc')->join('barang', 'barang.id_barang = aset_masuk.id_barang')->get()->getResultArray();
    }

    public function getAsetMasukByDate($tgl_dari, $tgl_sampai)
    {
        return $this->db->table('aset_masuk')->select('*')
            ->orderBy('tanggal_masuk', 'Desc')
            ->where(['tanggal_masuk >=' => $tgl_dari, 'tanggal_masuk <=' => $tgl_sampai])
            ->join('barang', 'barang.id_barang = aset_masuk.id_barang')->get()->getResultArray();
    }
}
