<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Data User',
            'users' => $this->userModel->where('role !=', 1)->orderBy('role', 'asc')->findAll(),
        ];

        return view('user/index', $data);
    }

    public function create()
    {
        if (session()->get('role') != 1) {
            return redirect()->to('/user');
        }

        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Tambah Data User',
            'validation' => \Config\Services::validation(),
        ];

        return view('user/add', $data);
    }

    public function save()
    {
        // validasi input
        if (!$this->validate([
            'nik' => [
                'rules' => 'trim|required|numeric|min_length[16]|max_length[16]|is_unique[user.nik]',
                'errors' => [
                    'required' => 'NIK harus diisi!',
                    'numeric' => 'NIK harus angka!',
                    'min_length' => 'NIK kurang dari 16 digit!',
                    'max_length' => 'NIK lebih dari 16 digit!',
                    'is_unique' => 'NIK sudah terdaftar!',
                ]
            ],
            'name' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama harus diisi!',
                ]
            ],
            'username' => [
                'rules' => 'trim|required|is_unique[user.username]',
                'errors' => [
                    'required' => 'Username harus diisi!',
                    'is_unique' => 'Username sudah terdaftar!',
                ]
            ],
            'email' => [
                'rules' => 'trim|required|valid_email|is_unique[user.email]',
                'errors' => [
                    'required' => 'Email harus diisi!',
                    'valid_email' => 'Email sudah terdaftar!',
                    'is_unique' => 'Email sudah terdaftar!',
                ]
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Level User harus dipilih!',
                ]
            ],
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin harus dipilih!',
                ]
            ],
            'telephone' => [
                'rules' => 'trim|required|numeric|min_length[11]|max_length[13]',
                'errors' => [
                    'required' => 'No. HP harus diisi!',
                    'numeric' => 'No. HP harus angka!',
                    'min_length' => 'No. HP kurang dari 11 digit!',
                    'max_length' => 'No. HP lebih dari 13 digit!',
                ]
            ],
            'address' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Alamat harus diisi!',
                ]
            ],
            'password' => [
                'rules' => 'trim|required|min_length[8]|matches[password_conf]',
                'errors' => [
                    'required' => 'Password harus diisi!',
                    'min_length' => 'Password kurang dari 8 karakter!',
                    'matches' => 'Password tidak sama dengan Konfirmasi Password!',
                ]
            ],
            'password_conf' => [
                'rules' => 'trim|required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Password harus diisi!',
                    'matches' => 'Konfirmasi Password tidak sama dengan Password!',
                ]
            ],
        ])) {
            return redirect()->to('/user/add')->withInput();
        }

        $this->userModel->save([

            'nik' => $this->request->getVar('nik'),
            'name' => $this->request->getVar('name'),
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'email' => $this->request->getVar('email'),
            'gender' => $this->request->getVar('gender'),
            'address' => $this->request->getVar('address'),
            'telephone' => $this->request->getVar('telephone'),
            'image' => 'default.jpg',
            'role' => $this->request->getVar('role'),
            'created_at' => date("d-m-Y")
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>user</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/user');
    }

    public function edit($nik)
    {
        if (session()->get('role') != 1) {
            return redirect()->to('/user');
        }

        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Ubah Data User',
            'validation' => \Config\Services::validation(),
            'user' => $this->userModel->where('nik', $nik)->first(),
        ];

        return view('user/edit', $data);
    }

    public function update($id)
    {
        // validasi input
        if (!$this->validate([
            'nik' => [
                'rules' => 'trim|required|numeric|min_length[16]|max_length[16]',
                'errors' => [
                    'required' => 'NIK harus diisi!',
                    'numeric' => 'NIK harus angka!',
                    'min_length' => 'NIK kurang dari 16 digit!',
                    'max_length' => 'NIK lebih dari 16 digit!',
                ]
            ],
            'name' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama harus diisi!',
                ]
            ],
            'username' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Username harus diisi!',
                ]
            ],
            'email' => [
                'rules' => 'trim|required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi!',
                    'valid_email' => 'Email sudah terdaftar!',
                ]
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Level User harus dipilih!',
                ]
            ],
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin harus dipilih!',
                ]
            ],
            'telephone' => [
                'rules' => 'trim|required|numeric|min_length[11]|max_length[13]',
                'errors' => [
                    'required' => 'No. HP harus diisi!',
                    'numeric' => 'No. HP harus angka!',
                    'min_length' => 'No. HP kurang dari 11 digit!',
                    'max_length' => 'No. HP lebih dari 13 digit!',
                ]
            ],
            'address' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Alamat harus diisi!',
                ]
            ],
        ])) {
            return redirect()->to('/user/edit')->withInput();
        }

        $this->userModel->save([
            'id' => $id,
            'nik' => $this->request->getVar('nik'),
            'name' => $this->request->getVar('name'),
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'gender' => $this->request->getVar('gender'),
            'address' => $this->request->getVar('address'),
            'telephone' => $this->request->getVar('telephone'),
            'role' => $this->request->getVar('role'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>user</strong> berhasil diupdate!</div>');

        return redirect()->to('/user');
    }

    public function delete($id)
    {
        if (session()->get('role') != 1) {
            return redirect()->to('/user');
        }

        $user = $this->userModel->find($id);

        if ($user['image'] != 'default.jpg') {
            unlink('img/' . $user['sampul']);
        }

        $this->userModel->delete($id);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>user</strong> berhasil dihapus!</div>');
        return redirect()->to('/user');
    }

    public function detail($nik = null)
    {
        $data = [
            'title' => 'Detail User',
            'user' => $this->userModel->where('nik', $nik)->first(),
        ];

        return view('user/detail', $data);
    }
}
