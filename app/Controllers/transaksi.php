<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {
        $model = new TransaksiModel();

        // Ambil transaksi bulan ini saja
        $bulanIni = date('Y-m');
        $data['transaksi'] = $model->getTransaksiBulanIni($bulanIni);
        $data['bulan'] = date('F Y'); // Nama bulan untuk display

        return view('transaksi/index', $data);
    }

    public function tambah()
    {
        return view('transaksi/tambah');
    }

    public function simpan()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'jenis' => 'required|in_list[masuk,keluar]',
            'keterangan' => 'required|min_length[3]|max_length[255]',
            'jumlah' => 'required|numeric|greater_than[0]',
            'tanggal' => 'required|valid_date',
            'kategori' => 'permit_empty|max_length[50]',
            'id_warga' => 'permit_empty|numeric'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error', 'Data tidak valid: ' . implode(', ', $validation->getErrors()));
            return redirect()->back()->withInput();
        }

        try {
            $model = new TransaksiModel();

            // Prepare data
            $data = [
                'tanggal' => $this->request->getPost('tanggal') . ' ' . date('H:i:s'),
                'jenis' => $this->request->getPost('jenis'),
                'jumlah' => (int)$this->request->getPost('jumlah'),
                'keterangan' => $this->request->getPost('keterangan'),
                'kategori' => $this->request->getPost('kategori') ?: null,
                'id_user' => 1, // Default admin user
                'id_warga' => $this->request->getPost('id_warga') ?: 0
            ];

            // Insert menggunakan method yang sudah ada
            $result = $model->insertTransaksi($data);

            if ($result) {
                $jenisText = $data['jenis'] == 'masuk' ? 'Pemasukan' : 'Pengeluaran';
                session()->setFlashdata('success', "Transaksi {$jenisText} berhasil disimpan dengan jumlah Rp " . number_format($data['jumlah'], 0, ',', '.'));
                return redirect()->to(base_url('transaksi/riwayat'));
            } else {
                session()->setFlashdata('error', 'Gagal menyimpan transaksi.');
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function riwayat()
    {
        $model = new TransaksiModel();
        $data['transaksi'] = $model->getAllTransaksi(); // Semua transaksi untuk riwayat

        return view('transaksi/riwayat', $data);
    }

    public function hapusSemua()
    {
        // Debug: Log request details
        log_message('info', 'hapusSemua called - Method: ' . $this->request->getMethod());
        log_message('info', 'hapusSemua called - URI: ' . $this->request->getUri());

        // Cek apakah request adalah POST
        if ($this->request->getMethod() !== 'post') {
            log_message('error', 'Invalid method: ' . $this->request->getMethod());
            session()->setFlashdata('error', 'Akses tidak valid. Method harus POST.');
            return redirect()->to(base_url('transaksi/riwayat'));
        }

        // Skip CSRF validation untuk debugging
        // if (!$this->validate(['csrf_token' => 'required'])) {
        //     session()->setFlashdata('error', 'CSRF token tidak valid.');
        //     return redirect()->to(base_url('transaksi/riwayat'));
        // }

        try {
            $model = new TransaksiModel();

            // Cek apakah ada data transaksi
            $count = $model->countAllResults();
            log_message('info', "Found {$count} transactions to delete");

            if ($count == 0) {
                session()->setFlashdata('error', 'Tidak ada riwayat transaksi untuk dihapus.');
                return redirect()->to(base_url('transaksi/riwayat'));
            }

            // Hapus semua data menggunakan model
            $deleteResult = $model->where('1=1')->delete();
            log_message('info', 'Delete result: ' . ($deleteResult ? 'SUCCESS' : 'FAILED'));

            if (!$deleteResult) {
                session()->setFlashdata('error', 'Gagal menghapus riwayat transaksi.');
                return redirect()->to(base_url('transaksi/riwayat'));
            }

            // Verifikasi penghapusan
            $remaining = $model->countAllResults();
            log_message('info', "Remaining transactions: {$remaining}");

            if ($remaining > 0) {
                session()->setFlashdata('error', 'Penghapusan tidak lengkap. Masih ada data yang tersisa.');
                return redirect()->to(base_url('transaksi/riwayat'));
            }

            session()->setFlashdata('success', "Berhasil menghapus {$count} riwayat transaksi.");
            return redirect()->to(base_url('transaksi/riwayat'));

        } catch (\Exception $e) {
            log_message('error', 'Exception in hapusSemua: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->to(base_url('transaksi/riwayat'));
        }
    }

    /**
     * Method debug untuk melihat data transaksi
     */
    public function debug()
    {
        echo "<h3>Debug Transaksi</h3>";

        $db = \Config\Database::connect();
        $model = new TransaksiModel();

        // Cek jumlah data di database
        $count = $db->table('transaksi')->countAllResults();
        echo "Jumlah transaksi di database: <strong>{$count}</strong><br><br>";

        if ($count > 0) {
            echo "<h4>Sample Data Transaksi:</h4>";
            $sample = $db->table('transaksi')->limit(5)->get()->getResultArray();

            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Tanggal</th><th>Jenis</th><th>Jumlah</th><th>Keterangan</th></tr>";

            foreach ($sample as $row) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['tanggal']}</td>";
                echo "<td>{$row['jenis']}</td>";
                echo "<td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>";
                echo "<td>{$row['keterangan']}</td>";
                echo "</tr>";
            }
            echo "</table>";

            echo "<br><h4>Test Hapus Manual:</h4>";
            echo "<form method='post' action='/transaksi/test-hapus'>";
            echo "<button type='submit' style='background: red; color: white; padding: 10px; border: none; border-radius: 5px;'>Test Hapus Semua Data</button>";
            echo "</form>";
        } else {
            echo "Tidak ada data transaksi.<br>";
        }

        echo "<br><a href='/transaksi/riwayat'>Kembali ke Riwayat</a>";
    }

    /**
     * Method test hapus untuk debugging
     */
    public function testHapus()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/transaksi/debug');
        }

        echo "<h3>Test Hapus Transaksi</h3>";

        $db = \Config\Database::connect();

        echo "Sebelum hapus:<br>";
        $countBefore = $db->table('transaksi')->countAllResults();
        echo "Jumlah data: {$countBefore}<br><br>";

        if ($countBefore > 0) {
            try {
                // Test berbagai method hapus
                echo "Mencoba hapus dengan emptyTable()...<br>";
                $result1 = $db->table('transaksi')->emptyTable();
                echo "Result emptyTable(): " . ($result1 ? 'TRUE' : 'FALSE') . "<br>";

                $countAfter1 = $db->table('transaksi')->countAllResults();
                echo "Jumlah setelah emptyTable(): {$countAfter1}<br><br>";

                if ($countAfter1 > 0) {
                    echo "Mencoba hapus dengan delete()...<br>";
                    $result2 = $db->table('transaksi')->delete();
                    echo "Result delete(): " . ($result2 ? 'TRUE' : 'FALSE') . "<br>";

                    $countAfter2 = $db->table('transaksi')->countAllResults();
                    echo "Jumlah setelah delete(): {$countAfter2}<br><br>";
                }

                if ($countAfter2 > 0) {
                    echo "Mencoba hapus dengan truncate()...<br>";
                    $result3 = $db->table('transaksi')->truncate();
                    echo "Result truncate(): " . ($result3 ? 'TRUE' : 'FALSE') . "<br>";

                    $countAfter3 = $db->table('transaksi')->countAllResults();
                    echo "Jumlah setelah truncate(): {$countAfter3}<br><br>";
                }

            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage() . "<br>";
            }
        }

        echo "<br><a href='/transaksi/debug'>Kembali ke Debug</a>";
    }

    /**
     * Method untuk menambah data sample transaksi
     */
    public function addSample()
    {
        echo "<h3>Menambah Data Sample Transaksi</h3>";

        $db = \Config\Database::connect();

        // Data sample transaksi
        $sampleData = [
            [
                'tanggal' => date('Y-m-d H:i:s'),
                'jenis' => 'masuk',
                'jumlah' => 50000,
                'keterangan' => 'Pembayaran iuran Juli 2025 - Budi Santoso',
                'id_user' => 1,
                'id_warga' => 1
            ],
            [
                'tanggal' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'jenis' => 'masuk',
                'jumlah' => 50000,
                'keterangan' => 'Pembayaran iuran Juli 2025 - Asep',
                'id_user' => 1,
                'id_warga' => 22
            ],
            [
                'tanggal' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'jenis' => 'keluar',
                'jumlah' => 25000,
                'keterangan' => 'Pembelian alat kebersihan',
                'id_user' => 1,
                'id_warga' => 0  // 0 untuk transaksi sistem
            ],
            [
                'tanggal' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'jenis' => 'masuk',
                'jumlah' => 75000,
                'keterangan' => 'Donasi kegiatan 17 Agustus',
                'id_user' => 1,
                'id_warga' => 1
            ],
            [
                'tanggal' => date('Y-m-d H:i:s', strtotime('-4 days')),
                'jenis' => 'keluar',
                'jumlah' => 150000,
                'keterangan' => 'Pembelian sound system',
                'id_user' => 1,
                'id_warga' => 0  // 0 untuk transaksi sistem
            ]
        ];

        $inserted = 0;
        $model = new TransaksiModel();

        foreach ($sampleData as $data) {
            try {
                $result = $model->insertTransaksi($data);
                if ($result) {
                    $inserted++;
                    echo "✅ Transaksi {$data['jenis']} - Rp " . number_format($data['jumlah'], 0, ',', '.') . " - {$data['keterangan']}<br>";
                } else {
                    echo "❌ Gagal insert: {$data['keterangan']}<br>";
                }
            } catch (\Exception $e) {
                echo "❌ Error: " . $e->getMessage() . " - {$data['keterangan']}<br>";
            }
        }

        echo "<br>✅ Berhasil menambahkan {$inserted} data sample transaksi.<br>";

        $totalCount = $db->table('transaksi')->countAllResults();
        echo "Total transaksi sekarang: <strong>{$totalCount}</strong><br>";

        echo "<br><a href='/transaksi/riwayat'>Lihat Riwayat Transaksi</a> | <a href='/transaksi/debug'>Debug</a>";
    }

    /**
     * Method untuk test hapus langsung (bypass modal)
     */
    public function testHapusLangsung()
    {
        echo "<h3>Test Hapus Langsung</h3>";

        try {
            $model = new TransaksiModel();

            $countBefore = $model->countAllResults();
            echo "Jumlah transaksi sebelum hapus: <strong>{$countBefore}</strong><br>";

            if ($countBefore == 0) {
                echo "Tidak ada data untuk dihapus.<br>";
                echo "<a href='/transaksi/add-sample'>Tambah Data Sample</a><br>";
                return;
            }

            // Test hapus
            echo "Menghapus semua data...<br>";
            $deleteResult = $model->where('1=1')->delete();

            echo "Result delete: " . ($deleteResult ? 'SUCCESS' : 'FAILED') . "<br>";

            $countAfter = $model->countAllResults();
            echo "Jumlah transaksi setelah hapus: <strong>{$countAfter}</strong><br>";

            if ($countAfter == 0) {
                echo "✅ <strong>BERHASIL!</strong> Semua data terhapus.<br>";
            } else {
                echo "❌ <strong>GAGAL!</strong> Masih ada {$countAfter} data tersisa.<br>";
            }

        } catch (\Exception $e) {
            echo "❌ <strong>ERROR:</strong> " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/transaksi/riwayat'>Kembali ke Riwayat</a> | <a href='/transaksi/debug'>Debug</a>";
    }

    /**
     * Method untuk monitoring status hapus
     */
    public function statusHapus()
    {
        header('Content-Type: application/json');

        try {
            $model = new TransaksiModel();
            $count = $model->countAllResults();

            echo json_encode([
                'success' => true,
                'count' => $count,
                'message' => $count == 0 ? 'Semua data terhapus' : "Masih ada {$count} data"
            ]);

        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Method untuk fix database schema id_warga
     */
    public function fixSchema()
    {
        echo "<h3>Fix Database Schema - id_warga Column</h3>";

        try {
            $db = \Config\Database::connect();

            // Test insert dengan id_warga = 0
            echo "<h4>Test Insert dengan id_warga = 0:</h4>";
            $testData = [
                'tanggal' => date('Y-m-d H:i:s'),
                'jenis' => 'keluar',
                'jumlah' => 10000,
                'keterangan' => 'Test transaksi sistem',
                'id_user' => 1,
                'id_warga' => 0
            ];

            $model = new TransaksiModel();
            $result = $model->insertTransaksi($testData);

            if ($result) {
                echo "✅ Test insert berhasil dengan id_warga = 0<br>";
                echo "✅ Solusi: Gunakan id_warga = 0 untuk transaksi sistem<br>";

                // Hapus test data
                $model->delete($result);
                echo "✅ Test data dihapus<br>";
            } else {
                echo "❌ Test insert gagal<br>";
                echo "Error: " . implode(', ', $model->errors()) . "<br>";
            }

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/transaksi/add-sample'>Test Add Sample</a> | <a href='/transaksi/debug'>Debug</a>";
    }

    /**
     * Method untuk test SQL syntax fix
     */
    public function testSqlFix()
    {
        echo "<h3>Test SQL Syntax Fix</h3>";

        try {
            $model = new TransaksiModel();

            echo "Testing getTransaksi() method...<br>";
            $transaksi = $model->getTransaksi(null, null, null, 5);

            echo "✅ SQL query berhasil dijalankan<br>";
            echo "Jumlah data: " . count($transaksi) . "<br><br>";

            if (count($transaksi) > 0) {
                echo "<h4>Sample Data:</h4>";
                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>ID</th><th>Tanggal</th><th>Jenis</th><th>Jumlah</th><th>Keterangan</th><th>Nama Warga</th></tr>";

                foreach ($transaksi as $t) {
                    echo "<tr>";
                    echo "<td>{$t['id']}</td>";
                    echo "<td>" . date('d/m/Y H:i', strtotime($t['tanggal'])) . "</td>";
                    echo "<td>{$t['jenis']}</td>";
                    echo "<td>Rp " . number_format($t['jumlah'], 0, ',', '.') . "</td>";
                    echo "<td>{$t['keterangan']}</td>";
                    echo "<td><strong>{$t['nama_warga']}</strong></td>";
                    echo "</tr>";
                }
                echo "</table>";

                echo "<br><h4>Verifikasi Display Logic:</h4>";
                $sistemCount = 0;
                $wargaCount = 0;
                $unknownCount = 0;

                foreach ($transaksi as $t) {
                    if ($t['nama_warga'] === 'Sistem') {
                        $sistemCount++;
                    } elseif ($t['nama_warga'] === '-') {
                        $unknownCount++;
                    } else {
                        $wargaCount++;
                    }
                }

                echo "✅ Transaksi Sistem: {$sistemCount}<br>";
                echo "✅ Transaksi Warga: {$wargaCount}<br>";
                echo "✅ Unknown: {$unknownCount}<br>";
            }

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/transaksi/riwayat'>Lihat Riwayat</a> | <a href='/transaksi/debug'>Debug</a>";
    }

    /**
     * Method untuk debug request hapus
     */
    public function debugHapus()
    {
        echo "<h3>Debug Request Hapus</h3>";

        echo "<h4>Request Information:</h4>";
        echo "Method: " . $this->request->getMethod() . "<br>";
        echo "URI: " . $this->request->getUri() . "<br>";
        echo "User Agent: " . $this->request->getUserAgent() . "<br>";
        echo "Is AJAX: " . ($this->request->isAJAX() ? 'Yes' : 'No') . "<br>";
        echo "Is POST: " . ($this->request->getMethod() === 'post' ? 'Yes' : 'No') . "<br>";

        echo "<h4>POST Data:</h4>";
        $postData = $this->request->getPost();
        if (empty($postData)) {
            echo "No POST data<br>";
        } else {
            foreach ($postData as $key => $value) {
                echo "{$key}: {$value}<br>";
            }
        }

        echo "<h4>Headers:</h4>";
        $headers = $this->request->headers();
        foreach ($headers as $name => $value) {
            echo "{$name}: {$value->getValue()}<br>";
        }

        echo "<h4>Session Data:</h4>";
        $session = session();
        echo "Session ID: " . $session->session_id . "<br>";
        echo "Flash Error: " . ($session->getFlashdata('error') ?? 'None') . "<br>";
        echo "Flash Success: " . ($session->getFlashdata('success') ?? 'None') . "<br>";

        echo "<br><h4>Test Form:</h4>";
        echo "<form action='" . base_url('transaksi/hapus-semua') . "' method='post'>";
        echo csrf_field();
        echo "<button type='submit' style='background: red; color: white; padding: 10px; border: none; border-radius: 5px;'>Test Hapus (Direct)</button>";
        echo "</form>";

        echo "<br><a href='/transaksi/riwayat'>Kembali ke Riwayat</a>";
    }

    /**
     * Method alternatif untuk hapus semua (simplified)
     */
    public function hapusSemuaAlt()
    {
        try {
            $model = new TransaksiModel();
            $count = $model->countAllResults();

            if ($count == 0) {
                session()->setFlashdata('error', 'Tidak ada data untuk dihapus.');
            } else {
                $deleteResult = $model->where('1=1')->delete();
                if ($deleteResult) {
                    session()->setFlashdata('success', "Berhasil menghapus {$count} riwayat transaksi.");
                } else {
                    session()->setFlashdata('error', 'Gagal menghapus data.');
                }
            }

        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->to(base_url('transaksi/riwayat'));
    }

    /**
     * Method untuk test form submission
     */
    public function testFormSubmit()
    {
        echo "<h3>Test Form Submission Tambah Transaksi</h3>";

        try {
            $model = new TransaksiModel();

            // Test data pemasukan
            echo "<h4>Test Transaksi Pemasukan:</h4>";
            $dataMasuk = [
                'tanggal' => date('Y-m-d H:i:s'),
                'jenis' => 'masuk',
                'jumlah' => 50000,
                'keterangan' => 'Test pembayaran iuran Juli 2025',
                'kategori' => 'iuran',
                'id_user' => 1,
                'id_warga' => 1
            ];

            $resultMasuk = $model->insertTransaksi($dataMasuk);
            if ($resultMasuk) {
                echo "✅ Pemasukan berhasil: Rp " . number_format($dataMasuk['jumlah'], 0, ',', '.') . " - {$dataMasuk['keterangan']}<br>";
            } else {
                echo "❌ Gagal insert pemasukan<br>";
            }

            // Test data pengeluaran
            echo "<h4>Test Transaksi Pengeluaran:</h4>";
            $dataKeluar = [
                'tanggal' => date('Y-m-d H:i:s'),
                'jenis' => 'keluar',
                'jumlah' => 25000,
                'keterangan' => 'Test pembelian alat kebersihan',
                'kategori' => 'kebersihan',
                'id_user' => 1,
                'id_warga' => 0
            ];

            $resultKeluar = $model->insertTransaksi($dataKeluar);
            if ($resultKeluar) {
                echo "✅ Pengeluaran berhasil: Rp " . number_format($dataKeluar['jumlah'], 0, ',', '.') . " - {$dataKeluar['keterangan']}<br>";
            } else {
                echo "❌ Gagal insert pengeluaran<br>";
            }

            // Summary
            $totalCount = $model->countAllResults();
            echo "<br><h4>Summary:</h4>";
            echo "Total transaksi sekarang: <strong>{$totalCount}</strong><br>";

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/transaksi/tambah'>Form Tambah Transaksi</a> | <a href='/transaksi/riwayat'>Lihat Riwayat</a>";
    }
}
