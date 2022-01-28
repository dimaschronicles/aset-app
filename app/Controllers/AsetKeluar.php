<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\AsetMasukModel;
use App\Controllers\BaseController;
use App\Models\AsetKeluarModel;

class AsetKeluar extends BaseController
{
    public function __construct()
    {
        $this->aset = new AsetModel();
        $this->asetKeluar = new AsetKeluarModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Aset Keluar',
            'validation' => \Config\Services::validation(),
            'aset' => $this->aset->getAllAset(),
            'asetKeluar' => $this->asetKeluar->getAsetKeluar(),
            'user' => session()->get('nama'),
        ];

        return view('aset_keluar/index', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'id_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Aset harus diisi!',
                ]
            ],
            'jumlah' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'Jumlah harus diisi!',
                    'numeric' => 'Jumlah harus angka!',
                ]
            ],
            'keterangan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Keterangan harus diisi!',
                ]
            ],
            'tanggal_keluar' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Tanggal Keluar harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/asetkeluar')->withInput();
        }

        $id_aset = $this->request->getVar('id_aset');
        $a = $this->db->query('SELECT * FROM aset WHERE id_barang=' . $id_aset)->getRowArray();
        $jumlah = $this->request->getVar('jumlah');
        $total = intval($a['jumlah']) - intval($jumlah);

        $dbarang = [
            'jumlah' => $total,
        ];
        $builder = $this->db->table('aset');
        $builder->where('id_barang', $id_aset);
        $builder->update($dbarang);

        $this->asetKeluar->save([
            'id_barang' => $id_aset,
            'keterangan' => $this->request->getVar('keterangan'),
            'tanggal_keluar' => $this->request->getVar('tanggal_keluar'),
            'jumlah' => $jumlah,
            'user_penginput' => $this->request->getVar('user_penginput'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/asetkeluar');
    }

    public function delete($id_aset)
    {
        $ak = $this->db->query('SELECT * FROM aset_keluar WHERE id_aset_keluar=' . $id_aset)->getRowArray();
        $id_ak = $ak['id_barang'];
        $jmlh_ak = $ak['jumlah'];


        $a = $this->db->query('SELECT * FROM aset WHERE id_barang=' . $id_ak)->getRowArray();
        $jmlh_a = $a['jumlah'];

        // ubah jumlah aset
        $total = intval($jmlh_a) + intval($jmlh_ak);

        $dbarang = [
            'jumlah' => $total,
        ];
        $builder = $this->db->table('aset');
        $builder->where('id_barang', $id_ak);
        $builder->update($dbarang);

        $builders = $this->db->table('aset_keluar');
        $builders->delete(['id_aset_keluar' => $id_aset]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset keluar</strong> berhasil dihapus!</div>');
        return redirect()->to('/asetkeluar');
    }
}
