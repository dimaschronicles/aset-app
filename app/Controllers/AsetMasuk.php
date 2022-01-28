<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\AsetMasukModel;
use App\Controllers\BaseController;

class AsetMasuk extends BaseController
{
    public function __construct()
    {
        $this->aset = new AsetModel();
        $this->asetMasuk = new AsetMasukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Aset Masuk',
            'validation' => \Config\Services::validation(),
            'aset' => $this->aset->getAllAset(),
            'asetMasuk' => $this->asetMasuk->getAsetMasuk(),
            'user' => session()->get('nama'),
        ];

        return view('aset_masuk/index', $data);
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
            'tanggal_masuk' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Tanggal Masuk harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/asetmasuk')->withInput();
        }

        $id_aset = $this->request->getVar('id_aset');
        $a = $this->db->query('SELECT * FROM aset WHERE id_barang=' . $id_aset)->getRowArray();
        $jumlah = $this->request->getVar('jumlah');
        $total = intval($a['jumlah']) + intval($jumlah);

        $dbarang = [
            'jumlah' => $total,
        ];
        $builder = $this->db->table('aset');
        $builder->where('id_barang', $id_aset);
        $builder->update($dbarang);

        $this->asetMasuk->save([
            'id_barang' => $id_aset,
            'keterangan' => $this->request->getVar('keterangan'),
            'tanggal_masuk' => $this->request->getVar('tanggal_masuk'),
            'jumlah' => $jumlah,
            'user_penginput' => $this->request->getVar('user_penginput'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset masuk</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/asetmasuk');
    }

    public function delete($id_aset)
    {
        $am = $this->db->query('SELECT * FROM aset_masuk WHERE id_aset_masuk=' . $id_aset)->getRowArray();
        $id_am = $am['id_barang'];
        $jmlh_am = $am['jumlah'];

        $a = $this->db->query('SELECT * FROM aset WHERE id_barang=' . $id_am)->getRowArray();
        $jmlh_a = $a['jumlah'];

        // ubah jumlah aset
        $total = intval($jmlh_a) - intval($jmlh_am);

        $dbarang = [
            'jumlah' => $total,
        ];
        $builder = $this->db->table('aset');
        $builder->where('id_barang', $id_am);
        $builder->update($dbarang);

        $builders = $this->db->table('aset_masuk');
        $builders->delete(['id_aset_masuk' => $id_aset]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset masuk</strong> berhasil dihapus!</div>');
        return redirect()->to('/asetmasuk');
    }
}
