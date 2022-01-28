<?php

namespace App\Models;

use CodeIgniter\Model;

class AsetKeluarModel extends Model
{
    protected $table = 'aset_keluar';
    protected $primaryKey = 'id_aset_keluar';
    protected $allowedFields = ['id_barang', 'jumlah', 'tanggal_keluar', 'keterangan', 'user_penginput'];

    public function getAsetKeluar()
    {
        return $this->db->table('aset_keluar')->select('*')->orderBy('tanggal_keluar', 'Desc')->join('barang', 'barang.id_barang = aset_keluar.id_barang')->get()->getResultArray();
    }

    public function getAsetKeluarByDate($tgl_dari, $tgl_sampai)
    {
        return $this->db->table('aset_keluar')->select('*')
            ->orderBy('tanggal_keluar', 'Desc')
            ->where(['tanggal_keluar >=' => $tgl_dari, 'tanggal_keluar <=' => $tgl_sampai])
            ->join('barang', 'barang.id_barang = aset_keluar.id_barang')->get()->getResultArray();
    }
}
