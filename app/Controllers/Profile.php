<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Edit Profil',
            'validation' => \Config\Services::validation(),
            'user' => $this->userModel->where('username', session()->get('username'))->first(),
        ];

        return view('profile/edit_profile', $data);
    }

    public function editProfile()
    {
        // validasi input
        if (!$this->validate([
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
            'telephone' => [
                'rules' => 'trim|required|numeric|min_length[11]|max_length[13]',
                'errors' => [
                    'required' => 'No. HP harus diisi!',
                    'numeric' => 'No. HP harus angka!',
                    'min_length' => 'No. HP kurang dari 11 digit!',
                    'max_length' => 'No. HP lebih dari 13 digit!',
                ]
            ],
            'image' => [
                'rules' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!'
                ]
            ]
        ])) {
            return redirect()->to('/profile')->withInput();
        }

        $imgFile = $this->request->getFile('image');
        // cek gambar , apakah tetap gambar lama
        if ($imgFile->getError() == 4) {
            $imgName = $this->request->getVar('oldImage');
        } else {
            // generate nama file random
            $imgName = $imgFile->getRandomName();
            // upload gambar
            $imgFile->move('img/profile', $imgName);

            if ($this->request->getVar('oldImage') == 'default.jpg') {
                //
            } else if ($this->request->getVar('oldImage') != 'default.jpg') {
                unlink('img/profile/' . $this->request->getVar('oldImage'));
            }
        }

        $this->userModel->save([
            'id_user' => $this->request->getVar('id'),
            'nama' => $this->request->getVar('name'),
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'no_telp' => $this->request->getVar('telephone'),
            'foto' => $imgName,
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Profil berhasil disimpan!</div>');

        return redirect()->to('/profile');
    }

    public function changePassword()
    {
        $data = [
            'title' => 'Ganti Password',
            'validation' => \Config\Services::validation(),
            'user' => $this->userModel->where('username', session()->get('username'))->first(),
        ];

        return view('profile/change_password', $data);
    }

    public function change()
    {
        if (!$this->validate([
            'current_password' => [
                'rules' => 'trim|required|min_length[8]',
                'errors' => [
                    'required' => 'Password Saat Ini harus diisi!',
                    'min_length' => 'Password Saat Ini kurang dari 8 karakter!',
                ]
            ],
            'new_password' => [
                'rules' => 'trim|required|min_length[8]|matches[password_conf]',
                'errors' => [
                    'required' => 'Password Baru harus diisi!',
                    'min_length' => 'Password Baru kurang dari 8 karakter!',
                    'matches' => 'Password Baru tidak sama dengan Konfirmasi Password!',
                ]
            ],
            'password_conf' => [
                'rules' => 'trim|required|min_length[8]|matches[new_password]',
                'errors' => [
                    'required' => 'Konfirmasi Password Baru harus diisi!',
                    'min_length' => 'Konfirmasi Password Baru kurang dari 8 karakter!',
                    'matches' => 'Konfirmasi Password Baru tidak sama dengan Konfirmasi Password!',
                ]
            ]
        ])) {
            return redirect()->to('/profile/changepassword')->withInput();
        }

        $user = $this->userModel->where('username', session()->get('username'))->first();

        $current_password = $this->request->getVar('current_password');
        $new_password = $this->request->getVar('new_password');

        if (!password_verify($current_password, $user['password'])) {
            session()->setFlashdata('message', '<div class="alert alert-danger">Password saat ini salah!</div>');
            return redirect()->to('/profile/changepassword');
        } else {
            if ($current_password == $new_password) {
                session()->setFlashdata('message', '<div class="alert alert-danger">Password baru harus berbeda dengan password saat ini!</div>');
                return redirect()->to('/profile/changepassword');
            } else {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                $this->userModel->save([
                    'id_user' => $this->request->getVar('id'),
                    'password' => $password_hash,
                ]);

                session()->setFlashdata('message', '<div class="alert alert-success">Password berhasil diganti!</div>');

                return redirect()->to('/profile/changepassword');
            }
        }
    }

    public function resetPassword()
    {
        if (session()->get('role') != 1) {
            return redirect()->to('/profile');
        }

        $builder = $this->db->table('user');
        $user = $builder->get()->getResultArray();

        $data = [
            'title' => 'Reset Password',
            'validation' => \Config\Services::validation(),
            'user' => $user,
        ];

        return view('profile/reset_password', $data);
    }

    public function reset()
    {
        if (!$this->validate([
            'email' => [
                'rules' => 'trim|required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi!',
                    'valid_email' => 'Email sudah terdaftar!',
                ]
            ],
            'password' => [
                'rules' => 'trim|required|min_length[8]|matches[password_conf]',
                'errors' => [
                    'required' => 'Password Baru harus diisi!',
                    'min_length' => 'Password Baru kurang dari 8 karakter!',
                    'matches' => 'Password Baru tidak sama dengan Konfirmasi Password!',
                ]
            ],
            'password_conf' => [
                'rules' => 'trim|required|min_length[8]|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Password Baru harus diisi!',
                    'min_length' => 'Konfirmasi Password Baru kurang dari 8 karakter!',
                    'matches' => 'Konfirmasi Password Baru tidak sama dengan Konfirmasi Password!',
                ]
            ]
        ])) {
            return redirect()->to('/profile/resetpassword')->withInput();
        }

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $password_conf = $this->request->getVar('password_conf');

        $user = $this->userModel->findAll();
        $emailUser = array_column($user, 'email');

        if (!in_array($email, $emailUser)) {
            session()->setFlashdata('message', '<div class="alert alert-danger">Email belum terdaftar!</div>');
            return redirect()->to('/profile/resetpassword');
        } else {
            if ($password != $password_conf) {
                session()->setFlashdata('message', '<div class="alert alert-danger">Password tidak sama!</div>');
                return redirect()->to('/profile/resetpassword');
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $this->userModel->where('email', $email)->set('password', $password_hash)->update();

                session()->setFlashdata('message', '<div class="alert alert-success">Password <strong>' . $email . '</strong> berhasil direset!</div>');

                return redirect()->to('/profile/resetpassword');
            }
        }
    }
}
