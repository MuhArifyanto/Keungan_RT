<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class Pengeluaran extends BaseController
{
    protected $transaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
    }

    public function catat()
    {
        return view('pengeluaran/catat');
    }

    public function simpan()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'tanggal' => 'required|valid_date',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|greater_than[0]',
            'keterangan' => 'permit_empty|string'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Set timezone Indonesia
        date_default_timezone_set('Asia/Jakarta');

        // Ambil data dari form
        $tanggal = $this->request->getPost('tanggal');
        $kategori = $this->request->getPost('kategori');
        $jumlah = $this->request->getPost('jumlah');
        $keterangan = $this->request->getPost('keterangan');

        // Gabungkan tanggal dengan waktu saat ini
        $tanggalLengkap = $tanggal . ' ' . date('H:i:s');

        // Simpan ke database
        // Untuk pengeluaran, kita gunakan id_warga = 0 atau id_warga sistem
        $data = [
            'tanggal' => $tanggalLengkap,
            'jenis' => 'keluar', // Sesuai dengan TransaksiModel (masuk/keluar)
            'jumlah' => $jumlah,
            'keterangan' => "Pengeluaran {$kategori} - {$keterangan}",
            'id_user' => 1, // Default user
            'id_warga' => 1 // Gunakan ID warga default untuk pengeluaran sistem
        ];

        $saved = $this->transaksiModel->save($data);

        if ($saved) {
            return redirect()->to('/dashboard')->with('success', 'Pengeluaran berhasil dicatat dan akan muncul di riwayat transaksi.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan pengeluaran.');
        }
    }
}
