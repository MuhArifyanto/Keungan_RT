<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function saveRegister()
    {
        helper(['form']);
        
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[user.username]',
            'email'    => 'required|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return view('auth/register', [
                'validation' => $this->validator,
            ]);
        }

        $model = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'nama'     => $this->request->getPost('username'), // Use username as nama
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'User'
        ];
        $model->save($data);
        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
    }
}
