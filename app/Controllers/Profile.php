<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userId = session()->get('user_id');

        // Ambil data user dari database jika ada user_id
        if ($userId) {
            $userData = $userModel->find($userId);
            if ($userData) {
                // Update session dengan data terbaru dari database
                session()->set([
                    'nama' => $userData['nama'],
                    'email' => $userData['email'],
                    'username' => $userData['username'],
                    'created_at' => $userData['created_at'] ?? null
                ]);
            }
        }

        $data = [
            'title' => 'Profil Saya',
            'user' => [
                'nama' => session()->get('nama'),
                'email' => session()->get('email'),
                'username' => session()->get('username'),
                'role' => session()->get('role') ?? 'Administrator',
                'created_at' => session()->get('created_at'),
                'last_login' => session()->get('last_login')
            ]
        ];

        return view('profile', $data);
    }

    /**
     * Method untuk update profile
     */
    public function update()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'no_hp' => 'permit_empty|min_length[8]|max_length[20]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error', 'Data tidak valid: ' . implode(', ', $validation->getErrors()));
            return redirect()->back()->withInput();
        }

        try {
            $userModel = new UserModel();
            $userId = session()->get('user_id');

            $updateData = [
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'no_hp' => $this->request->getPost('no_hp')
            ];

            // Update password jika diisi
            $newPassword = $this->request->getPost('password');
            if (!empty($newPassword)) {
                if (strlen($newPassword) < 6) {
                    session()->setFlashdata('error', 'Password minimal 6 karakter');
                    return redirect()->back()->withInput();
                }
                $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            $result = $userModel->update($userId, $updateData);

            if ($result) {
                // Update session dengan data baru
                session()->set([
                    'nama' => $updateData['nama'],
                    'email' => $updateData['email'],
                    'no_hp' => $updateData['no_hp'] ?? session()->get('no_hp')
                ]);

                session()->setFlashdata('success', 'Profil berhasil diperbarui!');
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui profil');
            }

        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to('/profile');
    }
}
