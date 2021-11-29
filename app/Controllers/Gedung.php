<?php

namespace App\Controllers;

use App\Models\GedungModel;
use App\Controllers\BaseController;

class Gedung extends BaseController
{
    protected $gedungModel;

    public function __construct()
    {
        $this->gedungModel = new GedungModel();
    }

    public function index()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Data Gedung',
            'gedung' => $this->gedungModel->findAll(),
        ];

        return view('gedung/gedung', $data);
    }

    public function create()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Data Gedung',
            'validation' => \Config\Services::validation(),
        ];

        return view('gedung/add', $data);
    }

    public function save()
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
            return redirect()->to('/gedung/add')->withInput();
        }

        $this->gedungModel->save([
            'kode_gedung' => $this->request->getVar('kode'),
            'nama_gedung' => $this->request->getVar('nama'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>gedung</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/gedung');
    }

    public function edit($kode)
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Ubah Data Gedung',
            'validation' => \Config\Services::validation(),
            'gedung' => $this->gedungModel->where('kode_gedung', $kode)->first(),
        ];

        return view('gedung/edit', $data);
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
            return redirect()->to('/gedung/edit/' . $this->request->getVar('kode_gedung'))->withInput();
        }

        $this->gedungModel->save([
            'id_gedung' => $id,
            'kode_gedung' => $this->request->getVar('kode'),
            'nama_gedung' => $this->request->getVar('nama'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>gedung</strong> berhasil diubah!</div>');

        return redirect()->to('/gedung');
    }

    public function delete($id)
    {
        $this->gedungModel->delete($id);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>gedung</strong> berhasil dihapus!</div>');
        return redirect()->to('/gedung');
    }
}
