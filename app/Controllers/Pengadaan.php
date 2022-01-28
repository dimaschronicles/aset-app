<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\UserModel;
use App\Models\RuangModel;
use App\Models\BarangModel;
use App\Models\GedungModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use App\Controllers\BaseController;

class AsetMasuk extends BaseController
{
    public function __construct()
    {
        $this->user = new UserModel();
        $this->aset = new AsetModel();
        $this->barang = new BarangModel();
        $this->kategori = new KategoriModel();
        $this->supplier = new SupplierModel();
        $this->gedung = new GedungModel();
        $this->ruangan = new RuangModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Aset',
            'aset' => $this->aset->getAllAset(),
        ];

        return view('pengadaan/index', $data);
    }
}
