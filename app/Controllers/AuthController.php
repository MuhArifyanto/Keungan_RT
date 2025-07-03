<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Update last login
            $model->updateLastLogin($user['id_user']);

            // Set session dengan data lengkap
            $session->set([
                'user_id' => $user['id_user'],
                'username' => $user['username'],
                'nama' => $user['nama'] ?? $user['username'],
                'email' => $user['email'] ?? '',
                'no_hp' => $user['no_hp'] ?? '',
                'role' => $user['role'] ?? 'User',
                'logged_in' => true,
                'last_login' => date('Y-m-d H:i:s')
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
