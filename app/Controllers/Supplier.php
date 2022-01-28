<?php

namespace App\Controllers;

use App\Models\SupplierModel;

class Supplier extends BaseController
{
    public function __construct()
    {
        $this->supplier = new SupplierModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Supplier',
            'supplier' => $this->supplier->findAll(),
        ];

        return view('supplier/supplier', $data);
    }

    public function create()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Tambah Data Supplier',
            'validation' => \Config\Services::validation(),
        ];

        return view('supplier/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'kode' => [
                'rules' => 'trim|required|is_unique[supplier.kode_supplier]',
                'errors' => [
                    'required' => 'Kode Supplier harus diisi!',
                    'is_unique' => 'Kode Supplier sudah terdaftar!',
                ]
            ],
            'nama' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Supplier harus diisi!',
                ]
            ],
            'alamat' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Alamat Supplier harus diisi!',
                ]
            ],
            'no_telp' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'No Telp Supplier harus diisi!',
                    'numeric' => 'No Telp Supplier harus angka!',
                ]
            ],
        ])) {
            return redirect()->to('/supplier/add')->withInput();
        }

        $this->supplier->save([
            'kode_supplier' => $this->request->getVar('kode'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'no_telp' => $this->request->getVar('no_telp'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>supplier</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/supplier');
    }

    public function edit($kode)
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Ubah Data supplier',
            'validation' => \Config\Services::validation(),
            'supplier' => $this->supplier->where('kode_supplier', $kode)->first(),
        ];

        return view('supplier/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'kode' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Supplier harus diisi!',
                ]
            ],
            'nama' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Supplier harus diisi!',
                ]
            ],
            'alamat' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Alamat Supplier harus diisi!',
                ]
            ],
            'no_telp' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'No Telp Supplier harus diisi!',
                    'numeric' => 'No Telp Supplier harus angka!',
                ]
            ],
        ])) {
            return redirect()->to('/supplier/edit/' . $this->request->getVar('kode_supplier'))->withInput();
        }

        $this->supplier->save([
            'id_supplier' => $id,
            'kode_supplier' => $this->request->getVar('kode'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'no_telp' => $this->request->getVar('no_telp'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>supplier</strong> berhasil diubah!</div>');

        return redirect()->to('/supplier');
    }

    public function delete($id)
    {
        $this->supplier->delete($id);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>supplier</strong> berhasil dihapus!</div>');
        return redirect()->to('/supplier');
    }
}
