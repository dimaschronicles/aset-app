<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\UserModel;

class Home extends BaseController
{
    protected $asetModel;
    protected $userModel;

    public function __construct()
    {
        $this->asetModel = new AsetModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'dataAset' => $this->asetModel->countAllResults(),
            'dataAdmin' => $this->userModel->where('role', 2)->countAllResults(),
            'dataUser' => $this->userModel->where('role', 3)->countAllResults(),
            'dataUser' => $this->userModel->where('role', 3)->countAllResults(),
            'asetBaik' => $this->asetModel->where('kondisi_aset', 'Baik')->countAllResults(),
            'asetKurang' => $this->asetModel->where('kondisi_aset', 'Kurang')->countAllResults(),
            'asetRusak' => $this->asetModel->where('kondisi_aset', 'Rusak')->countAllResults(),
            'asetUnit' => $this->asetModel->where('satuan', 'Unit')->countAllResults(),
            'asetBuah' => $this->asetModel->where('satuan', 'Buah')->countAllResults(),
            'asetSet' => $this->asetModel->where('satuan', 'Set')->countAllResults(),
            'asetPaket' => $this->asetModel->where('satuan', 'Paket')->countAllResults(),
            'lastUpdated' => $this->asetModel->findColumn('created_at'),
            'dataAsetDelete' => $this->asetModel->onlyDeleted()->countAllResults(),
        ];

        return view('home/index', $data);
    }
}
