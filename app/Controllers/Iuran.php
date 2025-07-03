<?php

namespace App\Controllers;
use App\Models\IuranModel;
use App\Models\WargaModel;
use App\Models\TransaksiModel;

class Iuran extends BaseController
{
    protected $iuranModel;
    protected $wargaModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->iuranModel = new IuranModel();
        $this->wargaModel = new WargaModel();
        $this->transaksiModel = new TransaksiModel();
    }

    /**
     * Halaman daftar iuran
     */
    public function index()
    {
        $data = [
            'title' => 'Data Iuran',
            'iuran' => $this->iuranModel->getAllWithWarga()
        ];
        return view('iuran/index', $data);
    }

    /**
     * Tambah data iuran
     */
    public function create()
    {
        // Tampilkan form input
        $data = [
            'title' => 'Tambah Iuran',
            'warga' => $this->wargaModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('iuran/form', $data);
    }

    /**
     * Proses pembayaran iuran
     */
    public function bayar()
    {
        // Debug: Log request method and data
        $method = $this->request->getMethod();
        log_message('info', 'Request method: ' . $method);
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Raw input: ' . $this->request->getBody());
        log_message('info', 'Method comparison: ' . (strtolower($method) === 'post' ? 'MATCH' : 'NO MATCH'));

        if (strtolower($method) === 'post') {
            // Debug: Cek apakah ada data POST
            $postData = $this->request->getPost();
            log_message('info', 'POST data check: ' . (empty($postData) ? 'EMPTY' : 'HAS DATA'));

            if (empty($postData)) {
                log_message('error', 'No POST data received');
                return view('iuran/form', [
                    'warga' => $this->wargaModel->findAll(),
                    'error' => 'Data tidak diterima. Silakan coba lagi.'
                ]);
            }

            log_message('info', 'POST data received, proceeding to validation...');
            $validation = \Config\Services::validation();
            $validation->setRules([
                'id_warga' => 'required|numeric',
                'bulan' => 'required',
                'tahun' => 'required|numeric',
                'nominal' => 'required|numeric',
                'status' => 'required|in_list[lunas,belum_lunas]'
            ]);

            log_message('info', 'Starting validation...');
            $validationResult = $validation->withRequest($this->request)->run();
            log_message('info', 'Validation result: ' . ($validationResult ? 'PASSED' : 'FAILED'));

            if (!$validationResult) {
                $errors = $validation->getErrors();
                log_message('error', 'Validation failed: ' . json_encode($errors));
                return view('iuran/form', [
                    'warga' => $this->wargaModel->findAll(),
                    'validation' => $validation,
                    'errors' => $errors
                ]);
            }

            log_message('info', 'Validation passed, processing payment...');

            $id_warga = $this->request->getPost('id_warga');
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');

            // Cek apakah sudah pernah bayar untuk bulan dan tahun yang sama
            if ($this->iuranModel->sudahBayar($id_warga, $bulan, $tahun)) {
                session()->setFlashdata('error', 'Warga ini sudah membayar iuran untuk bulan ' . $bulan . ' ' . $tahun);
                return redirect()->back()->withInput();
            }

            $jumlah = $this->request->getPost('nominal');
            $status = $this->request->getPost('status');

            // Gunakan timezone Indonesia dan format yang lebih presisi
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');

            // Debug: Log waktu pembayaran
            log_message('info', 'Payment timestamp: ' . $tanggal . ' (timezone: Asia/Jakarta)');

            // Debug: Log data yang akan disimpan
            log_message('info', 'Saving iuran data: ' . json_encode([
                'id_warga' => $id_warga,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'jumlah' => $jumlah,
                'status' => $status,
                'tanggal' => $tanggal
            ]));

            try {
                // Simpan data iuran
                $iuranData = [
                    'id_warga' => $id_warga,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'nominal' => $jumlah,
                    'jumlah' => $jumlah,  // Isi kedua field untuk kompatibilitas
                    'status' => $status,
                    'tanggal' => $tanggal
                ];

                log_message('info', 'Saving iuran data: ' . json_encode($iuranData));
                $iuranSaved = $this->iuranModel->save($iuranData);

                if (!$iuranSaved) {
                    throw new \Exception('Gagal menyimpan data iuran');
                }

                $message = 'Pembayaran iuran berhasil dicatat.';

                // Jika status lunas, buat transaksi masuk otomatis
                log_message('info', 'Checking status for transaction: ' . $status);
                if ($status === 'lunas') {
                    log_message('info', 'Creating transaction for lunas payment');
                    // Ambil nama warga untuk keterangan
                    $warga = $this->wargaModel->where('warga_id', $id_warga)->first();
                    $namaWarga = $warga ? $warga['nama'] : 'Warga';

                    // Buat transaksi masuk
                    $userId = session()->get('user_id');
                    if (!$userId) {
                        // Jika tidak ada session, ambil user pertama atau buat default
                        $db = \Config\Database::connect();
                        $user = $db->table('user')->select('id_user')->limit(1)->get()->getRow();
                        $userId = $user ? $user->id_user : 1;
                    }

                    $transaksiData = [
                        'tanggal' => $tanggal,
                        'jenis' => 'masuk',
                        'jumlah' => $jumlah,
                        'keterangan' => "Pembayaran iuran {$bulan} {$tahun} - {$namaWarga}",
                        'id_user' => $userId,
                        'id_warga' => $id_warga
                    ];

                    log_message('info', 'Creating transaction with data: ' . json_encode($transaksiData));
                    $transaksiSaved = $this->transaksiModel->save($transaksiData);

                    if ($transaksiSaved) {
                        log_message('info', 'Transaction created successfully with ID: ' . $this->transaksiModel->getInsertID());
                        $message = "✅ Pembayaran iuran {$bulan} {$tahun} berhasil dicatat! Transaksi telah dibuat pada " . date('d M Y H:i', strtotime($tanggal)) . ". Data akan muncul di dashboard.";
                    } else {
                        log_message('error', 'Failed to create transaction: ' . json_encode($this->transaksiModel->errors()));
                        $message = 'Pembayaran iuran berhasil dicatat, tetapi gagal membuat transaksi. Silakan hubungi administrator.';
                    }
                }

                session()->setFlashdata('success', $message);
                log_message('info', 'Payment successful, redirecting to dashboard');
                return redirect()->to('/dashboard');

            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        // Jika GET request, tampilkan form
        return $this->create();
    }

}
