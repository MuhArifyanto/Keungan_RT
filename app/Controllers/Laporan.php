<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class Laporan extends BaseController
{
    // Index laporan - redirect ke form buat laporan
    public function index()
    {
        return redirect()->to('/laporan/buat');
    }

    // Menampilkan form buat laporan
    public function buat()
    {
        return view('laporan/tambah');
    }

    // Proses form laporan
    public function proses()
    {
        // Cek apakah request adalah POST
        if (!$this->request->getMethod() === 'post') {
            return redirect()->to('/laporan/buat')->with('error', 'Akses tidak valid. Silakan gunakan form untuk membuat laporan.');
        }

        $mulai     = $this->request->getPost('tanggal_mulai');
        $selesai   = $this->request->getPost('tanggal_selesai');
        $jenis     = $this->request->getPost('jenis');
        $kategori  = $this->request->getPost('kategori');

        $model = new TransaksiModel();

        // Validasi input
        if (!$mulai || !$selesai) {
            return redirect()->to('/laporan/buat')->with('error', 'Tanggal mulai dan selesai harus diisi.');
        }

        // Validasi tanggal
        if (strtotime($mulai) > strtotime($selesai)) {
            return redirect()->to('/laporan/buat')->with('error', 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai.');
        }

        $builder = $model->where('tanggal >=', $mulai . ' 00:00:00')
                         ->where('tanggal <=', $selesai . ' 23:59:59');

        // Map jenis dari form ke database
        if ($jenis) {
            if ($jenis == 'pemasukan') {
                $builder = $builder->where('jenis', 'masuk');
            } elseif ($jenis == 'pengeluaran') {
                $builder = $builder->where('jenis', 'keluar');
            }
        }

        // Filter kategori jika ada (meskipun field ini mungkin tidak ada di semua record)
        if ($kategori) {
            $builder = $builder->where('keterangan LIKE', '%' . $kategori . '%');
        }

        $laporan = $builder->orderBy('tanggal', 'DESC')->findAll();
        $filter = [
            'tanggal_mulai' => $mulai,
            'tanggal_selesai' => $selesai,
            'jenis' => $jenis,
            'kategori' => $kategori
        ];

        // Simpan data ke session untuk menghindari form resubmission
        session()->set('laporan_data', [
            'laporan' => $laporan,
            'filter' => $filter
        ]);

        // Redirect ke hasil untuk menghindari form resubmission
        return redirect()->to('/laporan/hasil');
    }

    // Method untuk handle GET request ke /laporan/proses
    public function prosesGet()
    {
        return redirect()->to('/laporan/buat')->with('error', 'Akses tidak valid. Silakan gunakan form untuk membuat laporan.');
    }

    // Method untuk menampilkan laporan dengan GET (untuk menghindari form resubmission)
    public function hasil()
    {
        // Jika tidak ada session data, redirect ke form
        if (!session()->has('laporan_data')) {
            return redirect()->to('/laporan/buat')->with('error', 'Silakan buat laporan terlebih dahulu.');
        }

        $data = session()->get('laporan_data');
        return view('laporan/hasil', $data);
    }
}
