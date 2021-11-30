<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    public function __construct()
    {
        $this->kategori = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kategori',
            'kategori' => $this->kategori->findAll(),
        ];

        return view('kategori/kategori', $data);
    }

    public function create()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Tambah Kategori',
            'validation' => \Config\Services::validation(),
        ];

        return view('kategori/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'kode' => [
                'rules' => 'trim|required|is_unique[kategori.kode_kategori]',
                'errors' => [
                    'required' => 'Kode Kategori harus diisi!',
                    'is_unique' => 'Kode Kategori sudah terdaftar!',
                ]
            ],
            'nama' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Kategori harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/kategori/add')->withInput();
        }

        $this->kategori->save([
            'kode_kategori' => $this->request->getVar('kode'),
            'nama_kategori' => $this->request->getVar('nama'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>kategori</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/kategori');
    }

    public function edit($kode)
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Ubah Data Kategori',
            'validation' => \Config\Services::validation(),
            'kategori' => $this->kategori->where('kode_kategori', $kode)->first(),
        ];

        return view('kategori/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'kode' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Kategori harus diisi!',
                ]
            ],
            'nama' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Kategori harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/kategori/edit/' . $this->request->getVar('kode_kategori'))->withInput();
        }

        $this->kategori->save([
            'id_kategori' => $id,
            'kode_kategori' => $this->request->getVar('kode'),
            'nama_kategori' => $this->request->getVar('nama'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>kategori</strong> berhasil diubah!</div>');

        return redirect()->to('/kategori');
    }

    public function delete($id)
    {
        $this->kategori->delete($id);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>kategori</strong> berhasil dihapus!</div>');
        return redirect()->to('/kategori');
    }
}
