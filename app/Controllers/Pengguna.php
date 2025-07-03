<?php

namespace App\Controllers;

use App\Models\UserModel;

class Pengguna extends BaseController
{
    public function profil()
    {
        $userId = session()->get('user_id'); // pastikan ini sesuai dengan nama session login kamu

        if (!$userId) {
            return redirect()->to('/login'); // redirect kalau belum login
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        return view('pengguna/profil', [
            'user' => $user
        ]);
    }
}
