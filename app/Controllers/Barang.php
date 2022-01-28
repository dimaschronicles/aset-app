<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Barang extends BaseController
{
    public function __construct()
    {
        $this->barang = new BarangModel();
        $this->kategori = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Barang',
            'barang' => $this->barang->findAll(),
        ];

        return view('barang/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Barang',
            'validation' => \Config\Services::validation(),
            'kategori' => $this->kategori->findAll(),
        ];

        return view('barang/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_barang' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Barang harus diisi!',
                ]
            ],
            'tanggal_perolehan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Tahun Perolehan harus diisi!',
                ]
            ],
            'merek' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Merek harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/barang/add')->withInput();
        }

        $this->barang->save([
            'nama_barang' => $this->request->getVar('nama_barang'),
            'merek' => $this->request->getVar('merek'),
            'tahun_perolehan' => $this->request->getVar('tanggal_perolehan'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>barang</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/barang');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Ubah Data Barang',
            'validation' => \Config\Services::validation(),
            'barang' => $this->barang->find($id),
        ];

        return view('barang/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama_barang' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Barang harus diisi!',
                ]
            ],
            'tahun_perolehan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Tahun Perolehan harus diisi!',
                ]
            ],
            'merek' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Merek harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/barang/edit/' . $this->request->getVar('id_barang'))->withInput();
        }

        $this->barang->save([
            'id_barang' => $id,
            'nama_barang' => $this->request->getVar('nama_barang'),
            'merek' => $this->request->getVar('merek'),
            'tahun_perolehan' => $this->request->getVar('tahun_perolehan'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>barang</strong> berhasil diubah!</div>');

        return redirect()->to('/barang');
    }

    public function delete($id)
    {
        $this->barang->delete($id);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>barang</strong> berhasil dihapus!</div>');
        return redirect()->to('/barang');
    }
}
