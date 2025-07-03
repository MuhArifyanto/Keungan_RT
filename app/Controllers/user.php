<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    // Tampilkan halaman profil
    public function profile()
    {
        $userModel = new UserModel();

        // Ambil user pertama sebagai contoh
        $data['user'] = $userModel->first(); // ganti dengan logika session bila perlu
        $data['title'] = 'Profil Saya';

        return view('user/profile', $data);
    }

    // Simpan data user
    public function simpan()
    {
        $userModel = new UserModel();

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $userModel->insert($data);

        return redirect()->to('/user/profile')->with('success', 'Data berhasil disimpan!');
    }
}
