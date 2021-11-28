<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        if (session('username')) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'PT. Satria Dirgantara',
            'validation' => \Config\Services::validation(),
        ];

        return view('auth/login', $data);
    }

    public function login()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username harus diisi!',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi!'
                ]
            ]
        ])) {
            return redirect()->to('auth')->withInput();
        }

        $userModel = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $dataUser = $userModel->getLogin($username);

        if (!empty($dataUser)) {
            if (password_verify($password, $dataUser['password'])) {
                session()->set([
                    'nik' => $dataUser['nik'],
                    'username' => $dataUser['username'],
                    'name' => $dataUser['name'],
                    'role' => $dataUser['role']
                ]);

                if ($dataUser['role'] == 1) {
                    return redirect()->to('home');
                } elseif ($dataUser['role'] == 2) {
                    return redirect()->to('home');
                } elseif ($dataUser['role'] == 3) {
                    return redirect()->to('home');
                }
            } else {
                session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Cek <strong>username</strong> atau <strong>password</strong> anda!</div>');
                return redirect()->to('auth')->withInput();
            }
        } else {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Cek <strong>username</strong> atau <strong>password</strong> anda!</div>');
            return redirect()->to('auth')->withInput();
        }
    }

    public function logout()
    {
        $array_items = ['nik', 'username', 'role'];
        session()->remove($array_items);
        session()->setFlashdata('message', '<div class="alert alert-success" role="alert">Anda berhasil keluar!</div>');
        return redirect()->to('auth')->withInput();
    }

    public function block401()
    {
        return view('auth/block');
    }
}
