<?php

namespace App\Controllers;

use App\Models\GedungModel;
use App\Models\RuangModel;

class Ruangan extends BaseController
{
    public function __construct()
    {
        $this->ruangan = new RuangModel();
        $this->gedung = new GedungModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Ruangan',
            'ruangan' => $this->ruangan->getRuang(),
        ];

        return view('ruangan/ruangan', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Ruangan',
            'validation' => \Config\Services::validation(),
            'gedung' => $this->gedung->findAll(),
        ];

        return view('ruangan/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'kode' => [
                'rules' => 'trim|required|is_unique[ruangan.kode_ruangan]',
                'errors' => [
                    'required' => 'Kode Ruangan harus diisi!',
                    'is_unique' => 'Kode Ruangan sudah terdaftar!',
                ]
            ],
            'nama' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Ruangan harus diisi!',
                ]
            ],
            'gedung' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Lokasi Gedung harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/ruangan/add')->withInput();
        }

        $this->ruangan->save([
            'kode_ruangan' => $this->request->getVar('kode'),
            'nama_ruangan' => $this->request->getVar('nama'),
            'id_gedung' => $this->request->getVar('gedung'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>ruangan</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/ruangan');
    }

    public function edit($kode)
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Ubah Data Ruangan',
            'validation' => \Config\Services::validation(),
            'ruangan' => $this->ruangan->getRuang($kode),
            'gedung' => $this->gedung->findAll(),
        ];

        return view('ruangan/edit', $data);
    }

    public function update($id)
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
            'gedung' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Lokasi Gedung harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/ruangan/edit/' . $this->request->getVar('kode_ruangan'))->withInput();
        }

        $this->ruangan->save([
            'id_ruangan' => $id,
            'kode_ruangan' => $this->request->getVar('kode'),
            'nama_ruangan' => $this->request->getVar('nama'),
            'id_gedung' => $this->request->getVar('gedung'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>ruangan</strong> berhasil diubah!</div>');

        return redirect()->to('/ruangan');
    }

    public function delete($id)
    {
        $this->ruangan->delete($id);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>ruangan</strong> berhasil dihapus!</div>');
        return redirect()->to('/ruangan');
    }
}
