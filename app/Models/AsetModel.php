<?php

namespace App\Models;

use CodeIgniter\Model;

class AsetModel extends Model
{
    protected $table = 'aset';
    protected $primaryKey = 'id_aset';
    protected $allowedFields = ['kode_aset', 'id_barang', 'id_kategori', 'jumlah', 'satuan', 'kondisi', 'id_gedung', 'id_ruangan', 'nilai_aset', 'total_aset', 'id_supplier', 'keterangan', 'tanggal_masuk', 'foto', 'qr_code', 'status', 'user_penginput'];

    public function getAllAset($kondisi = false)
    {
        return $this->db->table('aset')->select('*')->where(['status' => 'Aktif', 'kondisi' => $kondisi])
            ->orderBy('kode_aset', 'DESC')
            ->join('barang', 'barang.id_barang = aset.id_barang')
            ->join('gedung', 'gedung.id_gedung = aset.id_gedung')
            ->join('ruangan', 'ruangan.id_ruangan = aset.id_ruangan')
            ->join('supplier', 'supplier.id_supplier = aset.id_supplier')
            ->join('kategori', 'kategori.id_kategori = aset.id_kategori')
            ->get()->getResultArray();
    }

    public function getAllAsetNon()
    {
        return $this->db->table('aset')->select('*')->where('status', 'Non Aktif')
            ->orderBy('kode_aset', 'DESC')
            ->join('barang', 'barang.id_barang = aset.id_barang')
            ->join('gedung', 'gedung.id_gedung = aset.id_gedung')
            ->join('ruangan', 'ruangan.id_ruangan = aset.id_ruangan')
            ->join('supplier', 'supplier.id_supplier = aset.id_supplier')
            ->join('kategori', 'kategori.id_kategori = aset.id_kategori')
            ->get()->getResultArray();
    }

    public function getAset($kodeAset)
    {
        return $this->db->table('aset')->select('*')->where('kode_aset', $kodeAset)
            ->join('barang', 'barang.id_barang = aset.id_barang')
            ->join('gedung', 'gedung.id_gedung = aset.id_gedung')
            ->join('ruangan', 'ruangan.id_ruangan = aset.id_ruangan')
            ->join('supplier', 'supplier.id_supplier = aset.id_supplier')
            ->join('kategori', 'kategori.id_kategori = aset.id_kategori')
            ->get()->getRowArray();
    }

    public function getGedung()
    {
        return $this->db->table('gedung')->select('*')->get()->getResultArray();
    }

    public function getRuangan()
    {
        return $this->db->table('ruangan')->select('*')
            ->join('gedung', 'gedung.id_gedung = ruangan.id_gedung')
            ->get()->getResultArray();
    }

    public function getAsetLama($id_aset)
    {
        return $this->db->table('aset')->select('*')->where('id_aset', $id_aset)->get()->getRowArray();
    }
}
