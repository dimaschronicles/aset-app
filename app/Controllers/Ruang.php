<?php

namespace App\Controllers;

use App\Models\RuangModel;
use App\Controllers\BaseController;

class Ruang extends BaseController
{
    protected $ruangModel;

    public function __construct()
    {
        $this->ruangModel = new RuangModel();
    }

    public function index()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Data Ruangan',
            'ruang' => $this->ruangModel->findAll(),
        ];

        return view('ruang/ruangan', $data);
    }

    public function create()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Tambah Data Ruangan',
            'validation' => \Config\Services::validation(),
        ];

        return view('ruang/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'kode' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Ruangan harus diisi!',
                ]
            ],
            'nama' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Ruangan harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/ruang/add')->withInput();
        }

        $this->ruangModel->save([
            'kode' => $this->request->getVar('kode'),
            'nama' => $this->request->getVar('nama'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>ruangan</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/ruang');
    }

    public function edit($kode)
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Ubah Data Ruangan',
            'validation' => \Config\Services::validation(),
            'ruang' => $this->ruangModel->where('kode', $kode)->first(),
        ];

        return view('ruang/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'kode' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Gedung harus diisi!',
                ]
            ],
            'nama' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Gedung harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/ruang/edit')->withInput();
        }

        $this->ruangModel->save([
            'id' => $id,
            'kode' => $this->request->getVar('kode'),
            'nama' => $this->request->getVar('nama'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>ruangan</strong> berhasil diubah!</div>');

        return redirect()->to('/ruang/edit/' . $this->request->getVar('kode'))->withInput();
    }

    public function delete($id)
    {
        $this->ruangModel->delete($id);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>ruangan</strong> berhasil dihapus!</div>');
        return redirect()->to('/ruang');
    }
}
