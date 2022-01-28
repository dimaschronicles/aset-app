<?php

namespace App\Controllers;

use App\Models\AsetKeluarModel;
use App\Models\AsetMasukModel;
use App\Models\AsetModel;
use App\Models\SupplierModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->aset = new AsetModel();
        $this->asetMasuk = new AsetMasukModel();
        $this->asetKeluar = new AsetKeluarModel();
        $this->user = new UserModel();
        $this->supplier = new SupplierModel();
    }

    public function index()
    {
        $getJmlhAsetMasuk = $this->db->table('aset_masuk')->selectSum('jumlah')->get()->getResultArray();
        $getJmlhAsetKeluar = $this->db->table('aset_keluar')->selectSum('jumlah')->get()->getResultArray();
        $getTerakhirDiperbaharui = $this->db->table('aset')->select('created_at')->orderBy('created_at', 'desc')->get()->getResultArray();

        $data = [
            'title' => 'Dashboard',
            'aset' => $this->aset->where('status', 'Aktif')->countAllResults(),
            'asetMasuk' => $this->asetMasuk->countAllResults(),
            'asetKeluar' => $this->asetKeluar->countAllResults(),
            'asetDihapus' => $this->aset->where('status', 'Non Aktif')->countAllResults(),
            'user' => $this->user->where('role', 2)->countAllResults(),
            'supplier' => $this->supplier->countAllResults(),
            'jmlhAsetMasuk' => $getJmlhAsetMasuk[0]['jumlah'],
            'jmlhAsetKeluar' => $getJmlhAsetKeluar[0]['jumlah'],
            'asetUnit' => $this->aset->where('satuan', 'Unit')->countAllResults(),
            'asetBuah' => $this->aset->where('satuan', 'Buah')->countAllResults(),
            'asetSet' => $this->aset->where('satuan', 'Set')->countAllResults(),
            'asetPaket' => $this->aset->where('satuan', 'Paket')->countAllResults(),
            'asetBaik' => $this->aset->where('kondisi', 'Baik')->countAllResults(),
            'asetKurang' => $this->aset->where('kondisi', 'Kurang')->countAllResults(),
            'asetRusak' => $this->aset->where('kondisi', 'Rusak')->countAllResults(),
            'lastUpdated' => $getTerakhirDiperbaharui[0]['created_at'],
        ];

        return view('home/index', $data);
    }
}
