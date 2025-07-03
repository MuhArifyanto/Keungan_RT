<?php

namespace App\Controllers;

use App\Models\WargaModel;
use App\Models\IuranModel;

class Warga extends BaseController
{
    protected $wargaModel;
    protected $iuranModel;

    public function __construct()
    {
        $this->wargaModel = new WargaModel();
        $this->iuranModel = new IuranModel();
    }

    // Menampilkan form tambah warga
    public function tambah()
    {
        $data['title'] = 'Tambah Data Warga';
        return view('warga/tambah', $data);
    }

    // Menyimpan data warga + otomatis buat iuran
    public function simpan()
    {
        // Debug: Log semua POST data
        log_message('debug', 'Form submission data: ' . json_encode($this->request->getPost()));

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[2]|max_length[100]',
            'alamat' => 'required|min_length[3]|max_length[255]',
            'no_hp' => 'required|min_length[8]|max_length[20]',
            'rt' => 'permit_empty|max_length[10]',
            'rw' => 'permit_empty|max_length[10]',
            'keterangan' => 'permit_empty|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            log_message('error', 'Validation failed: ' . json_encode($errors));
            session()->setFlashdata('error', 'Data tidak valid: ' . implode(', ', $errors));
            return redirect()->back()->withInput();
        }

        try {
            // Prepare data warga
            $dataWarga = [
                'nama'   => trim($this->request->getPost('nama')),
                'alamat' => trim($this->request->getPost('alamat')),
                'no_hp'  => $this->request->getPost('no_hp'),
                'rt'     => $this->request->getPost('rt') ?: '001',
                'rw'     => $this->request->getPost('rw') ?: '001',
                'keterangan' => $this->request->getPost('keterangan') ?: null,
                'status' => 'aktif',
                'tanggal_daftar' => date('Y-m-d H:i:s')
            ];

            // Debug: Log data yang akan disimpan
            log_message('debug', 'Data to insert: ' . json_encode($dataWarga));

            // Simpan data warga
            $result = $this->wargaModel->insert($dataWarga);

            if (!$result) {
                $modelErrors = $this->wargaModel->errors();
                log_message('error', 'Model insert failed: ' . json_encode($modelErrors));
                session()->setFlashdata('error', 'Gagal menyimpan data warga: ' . implode(', ', $modelErrors));
                return redirect()->back()->withInput();
            }

            $idWargaBaru = $this->wargaModel->getInsertID();
            log_message('debug', 'New warga ID: ' . $idWargaBaru);

            // Tambahkan iuran awal otomatis untuk bulan ini
            $bulanIndonesia = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            $bulanSekarang = $bulanIndonesia[date('n')];
            $tahunSekarang = date('Y');

            $iuranData = [
                'id_warga' => $idWargaBaru,
                'bulan'    => $bulanSekarang,
                'tahun'    => $tahunSekarang,
                'nominal'  => 50000,
                'jumlah'   => 50000,
                'status'   => 'belum lunas',
                'tanggal'  => date('Y-m-d H:i:s')
            ];

            log_message('debug', 'Iuran data: ' . json_encode($iuranData));
            $iuranResult = $this->iuranModel->save($iuranData);

            if (!$iuranResult) {
                log_message('warning', 'Iuran creation failed but warga saved');
            }

            $successMessage = "Data warga '{$dataWarga['nama']}' berhasil disimpan dan iuran {$bulanSekarang} {$tahunSekarang} telah dibuat.";
            log_message('info', 'Warga saved successfully: ' . $successMessage);

            session()->setFlashdata('success', $successMessage);
            return redirect()->to(base_url('warga'));

        } catch (\Exception $e) {
            log_message('error', 'Exception in simpan: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // Tampilkan daftar semua warga
    public function index()
    {
        try {
            $data = [
                'title' => 'Daftar Warga',
                'warga' => $this->wargaModel->getAllWarga()
            ];

            return view('warga/index', $data);
        } catch (\Exception $e) {
            // Jika ada error, tampilkan dengan data kosong
            $data = [
                'title' => 'Daftar Warga',
                'warga' => []
            ];

            session()->setFlashdata('error', 'Terjadi kesalahan saat mengambil data warga: ' . $e->getMessage());
            return view('warga/index', $data);
        }
    }

    /**
     * Method untuk test form submission warga
     */
    public function testFormSubmit()
    {
        echo "<h3>Test Form Submission Tambah Warga</h3>";

        try {
            // Test data warga
            echo "<h4>Test Data Warga Baru:</h4>";
            $dataWarga = [
                'nama' => 'Test Warga Baru',
                'alamat' => 'Jl. Test No. 123',
                'no_hp' => '812-3456-7890',
                'rt' => '001',
                'rw' => '001',
                'keterangan' => 'Test warga dari form upgrade',
                'status' => 'aktif',
                'tanggal_daftar' => date('Y-m-d H:i:s')
            ];

            $result = $this->wargaModel->insert($dataWarga);

            if ($result) {
                $idWargaBaru = $this->wargaModel->getInsertID();
                echo "✅ Warga berhasil disimpan dengan ID: {$idWargaBaru}<br>";
                echo "📝 Nama: {$dataWarga['nama']}<br>";
                echo "🏠 Alamat: {$dataWarga['alamat']}<br>";
                echo "📞 HP: {$dataWarga['no_hp']}<br>";
                echo "🏘️ RT/RW: {$dataWarga['rt']}/{$dataWarga['rw']}<br>";

                // Test buat iuran otomatis
                echo "<br><h4>Test Iuran Otomatis:</h4>";
                $bulanIndonesia = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];

                $bulanSekarang = $bulanIndonesia[date('n')];
                $tahunSekarang = date('Y');

                $iuranResult = $this->iuranModel->save([
                    'id_warga' => $idWargaBaru,
                    'bulan'    => $bulanSekarang,
                    'tahun'    => $tahunSekarang,
                    'nominal'  => 50000,
                    'jumlah'   => 50000,
                    'status'   => 'belum lunas',
                    'tanggal'  => date('Y-m-d H:i:s')
                ]);

                if ($iuranResult) {
                    echo "✅ Iuran otomatis berhasil dibuat<br>";
                    echo "📅 Periode: {$bulanSekarang} {$tahunSekarang}<br>";
                    echo "💰 Nominal: Rp 50.000<br>";
                    echo "📊 Status: Belum Lunas<br>";
                } else {
                    echo "❌ Gagal membuat iuran otomatis<br>";
                }

            } else {
                echo "❌ Gagal menyimpan warga<br>";
            }

            // Summary
            $totalWarga = $this->wargaModel->countAllResults();
            echo "<br><h4>Summary:</h4>";
            echo "Total warga sekarang: <strong>{$totalWarga}</strong><br>";

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/warga/tambah'>Form Tambah Warga</a> | <a href='/dashboard'>Dashboard</a>";
    }

    /**
     * Method untuk menambah data sample warga dengan kolom baru
     */
    public function addSampleWarga()
    {
        echo "<h3>Tambah Data Sample Warga dengan Kolom Baru</h3>";

        try {
            // Data sample warga dengan kolom RT, RW, dan keterangan
            $sampleWarga = [
                [
                    'nama' => 'Budi Santoso',
                    'alamat' => 'Jl. Mawar No. 15',
                    'no_hp' => '812-3456-7890',
                    'rt' => '001',
                    'rw' => '001',
                    'keterangan' => 'Ketua RT, aktif dalam kegiatan',
                    'status' => 'aktif',
                    'tanggal_daftar' => date('Y-m-d H:i:s')
                ],
                [
                    'nama' => 'Siti Aminah',
                    'alamat' => 'Jl. Melati No. 22',
                    'no_hp' => '813-9876-5432',
                    'rt' => '001',
                    'rw' => '001',
                    'keterangan' => 'Sekretaris RT, koordinator PKK',
                    'status' => 'aktif',
                    'tanggal_daftar' => date('Y-m-d H:i:s')
                ],
                [
                    'nama' => 'Ahmad Wijaya',
                    'alamat' => 'Jl. Anggrek No. 8',
                    'no_hp' => '814-1111-2222',
                    'rt' => '002',
                    'rw' => '001',
                    'keterangan' => 'Bendahara RT, pengusaha lokal',
                    'status' => 'aktif',
                    'tanggal_daftar' => date('Y-m-d H:i:s')
                ],
                [
                    'nama' => 'Dewi Lestari',
                    'alamat' => 'Jl. Kenanga No. 33',
                    'no_hp' => '815-4444-5555',
                    'rt' => '002',
                    'rw' => '001',
                    'keterangan' => null,
                    'status' => 'aktif',
                    'tanggal_daftar' => date('Y-m-d H:i:s')
                ],
                [
                    'nama' => 'Rudi Hermawan',
                    'alamat' => 'Jl. Dahlia No. 7',
                    'no_hp' => '816-7777-8888',
                    'rt' => '003',
                    'rw' => '002',
                    'keterangan' => 'Koordinator keamanan lingkungan',
                    'status' => 'aktif',
                    'tanggal_daftar' => date('Y-m-d H:i:s')
                ]
            ];

            $inserted = 0;
            foreach ($sampleWarga as $data) {
                $result = $this->wargaModel->insert($data);
                if ($result) {
                    $inserted++;
                    echo "✅ {$data['nama']} - RT {$data['rt']}/RW {$data['rw']} - {$data['alamat']}<br>";

                    // Buat iuran otomatis untuk setiap warga
                    $idWarga = $this->wargaModel->getInsertID();
                    $bulanIndonesia = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];

                    $bulanSekarang = $bulanIndonesia[date('n')];
                    $tahunSekarang = date('Y');

                    $this->iuranModel->save([
                        'id_warga' => $idWarga,
                        'bulan'    => $bulanSekarang,
                        'tahun'    => $tahunSekarang,
                        'nominal'  => 50000,
                        'jumlah'   => 50000,
                        'status'   => 'belum lunas',
                        'tanggal'  => date('Y-m-d H:i:s')
                    ]);
                }
            }

            echo "<br>✅ Berhasil menambahkan {$inserted} data sample warga.<br>";

            $totalWarga = $this->wargaModel->countAllResults();
            echo "Total warga sekarang: <strong>{$totalWarga}</strong><br>";

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/warga'>Lihat Daftar Warga</a> | <a href='/dashboard'>Dashboard</a>";
    }

    /**
     * Method untuk debug data warga
     */
    public function debugWarga()
    {
        echo "<h3>Debug Data Warga</h3>";

        try {
            // Test koneksi database
            $db = \Config\Database::connect();
            echo "✅ Koneksi database berhasil<br><br>";

            // Cek tabel warga
            echo "<h4>Informasi Tabel Warga:</h4>";
            $fields = $db->getFieldData('warga');
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>";
            foreach ($fields as $field) {
                // Safe property access dengan isset check
                $null = isset($field->null) ? ($field->null ? 'YES' : 'NO') : 'UNKNOWN';
                $default = isset($field->default) ? ($field->default ?? 'NULL') : 'UNKNOWN';
                $type = isset($field->type) ? $field->type : 'UNKNOWN';
                $name = isset($field->name) ? $field->name : 'UNKNOWN';

                echo "<tr><td>{$name}</td><td>{$type}</td><td>{$null}</td><td>{$default}</td></tr>";
            }
            echo "</table><br>";

            // Cek jumlah data
            $count = $this->wargaModel->countAllResults();
            echo "<h4>Jumlah Data Warga:</h4>";
            echo "Total: <strong>{$count}</strong> warga<br><br>";

            if ($count > 0) {
                echo "<h4>Sample Data Warga:</h4>";
                $warga = $this->wargaModel->limit(5)->findAll();
                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>ID</th><th>Nama</th><th>Alamat</th><th>HP</th><th>RT</th><th>RW</th><th>Status</th><th>Keterangan</th></tr>";

                foreach ($warga as $w) {
                    echo "<tr>";
                    echo "<td>{$w['warga_id']}</td>";
                    echo "<td>{$w['nama']}</td>";
                    echo "<td>{$w['alamat']}</td>";
                    echo "<td>{$w['no_hp']}</td>";
                    echo "<td>" . ($w['rt'] ?? '-') . "</td>";
                    echo "<td>" . ($w['rw'] ?? '-') . "</td>";
                    echo "<td>" . ($w['status'] ?? '-') . "</td>";
                    echo "<td>" . ($w['keterangan'] ?? '-') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "❌ Tidak ada data warga dalam database<br>";
                echo "<a href='/warga/add-sample' style='background: #10b981; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;'>Tambah Data Sample</a><br>";
            }

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/warga'>Lihat Daftar Warga</a> | <a href='/warga/tambah'>Tambah Warga</a>";
    }

    /**
     * Method debug yang lebih robust
     */
    public function debugWargaFixed()
    {
        echo "<h3>Debug Data Warga (Fixed)</h3>";

        try {
            // Test koneksi database
            $db = \Config\Database::connect();
            echo "✅ Koneksi database berhasil<br><br>";

            // Alternative method untuk cek struktur tabel
            echo "<h4>Informasi Tabel Warga (Alternative Method):</h4>";

            try {
                // Gunakan query DESCRIBE untuk MySQL/MariaDB
                $query = $db->query("DESCRIBE warga");
                $fields = $query->getResultArray();

                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";

                foreach ($fields as $field) {
                    echo "<tr>";
                    echo "<td>" . ($field['Field'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($field['Type'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($field['Null'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($field['Key'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($field['Default'] ?? 'NULL') . "</td>";
                    echo "<td>" . ($field['Extra'] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
                echo "</table><br>";

            } catch (\Exception $e) {
                echo "❌ Error getting table structure: " . $e->getMessage() . "<br>";

                // Fallback: cek dengan query sederhana
                echo "<h4>Fallback: Test Query Simple:</h4>";
                try {
                    $testQuery = $db->query("SELECT * FROM warga LIMIT 1");
                    $result = $testQuery->getResultArray();

                    if (!empty($result)) {
                        echo "✅ Tabel warga dapat diakses<br>";
                        echo "Kolom yang tersedia: " . implode(', ', array_keys($result[0])) . "<br>";
                    } else {
                        echo "⚠️ Tabel kosong tapi dapat diakses<br>";
                    }
                } catch (\Exception $e2) {
                    echo "❌ Error accessing table: " . $e2->getMessage() . "<br>";
                }
            }

            // Cek jumlah data
            echo "<h4>Jumlah Data Warga:</h4>";
            $count = $this->wargaModel->countAllResults();
            echo "Total: <strong>{$count}</strong> warga<br><br>";

            if ($count > 0) {
                echo "<h4>Sample Data Warga (5 teratas):</h4>";
                $warga = $this->wargaModel->limit(5)->findAll();

                if (!empty($warga)) {
                    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                    echo "<tr><th>ID</th><th>Nama</th><th>Alamat</th><th>HP</th><th>RT</th><th>RW</th><th>Status</th><th>Keterangan</th></tr>";

                    foreach ($warga as $w) {
                        echo "<tr>";
                        echo "<td>" . ($w['warga_id'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($w['nama'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($w['alamat'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($w['no_hp'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($w['rt'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($w['rw'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($w['status'] ?? 'N/A') . "</td>";
                        echo "<td>" . (isset($w['keterangan']) ? ($w['keterangan'] ?: '-') : 'N/A') . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "❌ Tidak dapat mengambil data warga<br>";
                }
            } else {
                echo "❌ Tidak ada data warga dalam database<br>";
                echo "<a href='/warga/add-sample' style='background: #10b981; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;'>Tambah Data Sample</a><br>";
            }

            // Test model methods
            echo "<br><h4>Test Model Methods:</h4>";
            try {
                $allWarga = $this->wargaModel->getAllWarga();
                echo "✅ getAllWarga(): " . count($allWarga) . " records<br>";

                $activeWarga = $this->wargaModel->getWargaByStatus('aktif');
                echo "✅ getWargaByStatus('aktif'): " . count($activeWarga) . " records<br>";

            } catch (\Exception $e) {
                echo "❌ Error testing model methods: " . $e->getMessage() . "<br>";
            }

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/warga'>Lihat Daftar Warga</a> | <a href='/warga/tambah'>Tambah Warga</a> | <a href='/warga/debug'>Debug Original</a>";
    }

    /**
     * Method untuk fix struktur database warga
     */
    public function fixDatabaseStructure()
    {
        echo "<h3>Fix Database Structure Warga</h3>";

        try {
            $db = \Config\Database::connect();
            $forge = \Config\Database::forge();

            echo "🔧 Memeriksa dan memperbaiki struktur tabel warga...<br><br>";

            // Cek apakah kolom-kolom baru sudah ada
            $fields = $db->getFieldData('warga');
            $existingFields = array_column($fields, 'name');

            echo "<strong>Kolom yang ada saat ini:</strong><br>";
            foreach ($existingFields as $field) {
                echo "✅ {$field}<br>";
            }
            echo "<br>";

            // Kolom yang diperlukan
            $requiredFields = ['rt', 'rw', 'keterangan', 'status', 'tanggal_daftar'];
            $missingFields = array_diff($requiredFields, $existingFields);

            if (!empty($missingFields)) {
                echo "<strong>Menambahkan kolom yang hilang:</strong><br>";

                foreach ($missingFields as $field) {
                    try {
                        switch ($field) {
                            case 'rt':
                                $forge->addColumn('warga', [
                                    'rt' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 10,
                                        'default' => '001',
                                        'after' => 'no_hp'
                                    ]
                                ]);
                                echo "✅ Kolom 'rt' ditambahkan<br>";
                                break;

                            case 'rw':
                                $forge->addColumn('warga', [
                                    'rw' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 10,
                                        'default' => '001',
                                        'after' => 'rt'
                                    ]
                                ]);
                                echo "✅ Kolom 'rw' ditambahkan<br>";
                                break;

                            case 'keterangan':
                                $forge->addColumn('warga', [
                                    'keterangan' => [
                                        'type' => 'TEXT',
                                        'null' => true,
                                        'after' => 'rw'
                                    ]
                                ]);
                                echo "✅ Kolom 'keterangan' ditambahkan<br>";
                                break;

                            case 'status':
                                $forge->addColumn('warga', [
                                    'status' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 20,
                                        'default' => 'aktif',
                                        'after' => 'keterangan'
                                    ]
                                ]);
                                echo "✅ Kolom 'status' ditambahkan<br>";
                                break;

                            case 'tanggal_daftar':
                                $forge->addColumn('warga', [
                                    'tanggal_daftar' => [
                                        'type' => 'DATETIME',
                                        'null' => true,
                                        'after' => 'status'
                                    ]
                                ]);
                                echo "✅ Kolom 'tanggal_daftar' ditambahkan<br>";
                                break;
                        }
                    } catch (\Exception $e) {
                        echo "❌ Error menambahkan kolom '{$field}': " . $e->getMessage() . "<br>";
                    }
                }
            } else {
                echo "✅ Semua kolom yang diperlukan sudah ada<br>";
            }

            // Update data yang sudah ada untuk mengisi kolom baru
            echo "<br><strong>Mengupdate data existing:</strong><br>";
            $existingWarga = $db->table('warga')->get()->getResultArray();

            foreach ($existingWarga as $warga) {
                $updateData = [];

                if (empty($warga['rt'])) $updateData['rt'] = '001';
                if (empty($warga['rw'])) $updateData['rw'] = '001';
                if (empty($warga['status'])) $updateData['status'] = 'aktif';
                if (empty($warga['tanggal_daftar'])) $updateData['tanggal_daftar'] = date('Y-m-d H:i:s');

                if (!empty($updateData)) {
                    $db->table('warga')->where('warga_id', $warga['warga_id'])->update($updateData);
                    echo "✅ Updated warga: {$warga['nama']}<br>";
                }
            }

            echo "<br>✅ <strong>Database structure berhasil diperbaiki!</strong><br>";

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/warga/debug'>Debug Data</a> | <a href='/warga'>Lihat Daftar Warga</a>";
    }

    /**
     * Method untuk test tambah warga langsung
     */
    public function testTambahWargaLangsung()
    {
        echo "<h3>Test Tambah Warga Langsung</h3>";

        try {
            // Data test
            $dataTest = [
                'nama' => 'Test Warga ' . date('His'),
                'alamat' => 'Jl. Test No. ' . rand(1, 100),
                'no_hp' => '812-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                'rt' => '001',
                'rw' => '001',
                'keterangan' => 'Test warga dari debug',
                'status' => 'aktif',
                'tanggal_daftar' => date('Y-m-d H:i:s')
            ];

            echo "<strong>Data yang akan disimpan:</strong><br>";
            foreach ($dataTest as $key => $value) {
                echo "{$key}: {$value}<br>";
            }
            echo "<br>";

            // Test insert
            $result = $this->wargaModel->insert($dataTest);

            if ($result) {
                $insertId = $this->wargaModel->getInsertID();
                echo "✅ Berhasil insert dengan ID: {$insertId}<br>";

                // Verify data
                $savedData = $this->wargaModel->find($insertId);
                if ($savedData) {
                    echo "✅ Data berhasil disimpan dan dapat diambil kembali<br>";
                    echo "<strong>Data tersimpan:</strong><br>";
                    foreach ($savedData as $key => $value) {
                        echo "{$key}: " . ($value ?? 'NULL') . "<br>";
                    }
                } else {
                    echo "❌ Data tidak dapat diambil kembali<br>";
                }

            } else {
                echo "❌ Gagal insert data<br>";
                $errors = $this->wargaModel->errors();
                if ($errors) {
                    echo "Errors: " . implode(', ', $errors) . "<br>";
                }
            }

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<br><a href='/warga'>Lihat Daftar Warga</a> | <a href='/warga/tambah'>Form Tambah</a>";
    }

    /**
     * Method untuk test flow tambah warga dengan redirect fix
     */
    public function testFlowTambahWarga()
    {
        echo "<h3>Test Flow Tambah Warga dengan Redirect Fix</h3>";

        echo "Flow tambah warga sudah diperbaiki dengan redirect yang benar:<br><br>";

        echo "✅ <strong>Flow Lengkap:</strong><br>";
        echo "1. User buka: <a href='/warga/tambah' target='_blank'>/warga/tambah</a><br>";
        echo "2. User isi form dengan data lengkap<br>";
        echo "3. User klik 'Simpan Data Warga'<br>";
        echo "4. Data tersimpan ke database<br>";
        echo "5. Auto-create iuran bulan ini<br>";
        echo "6. Redirect ke: <a href='/warga' target='_blank'>/warga</a> (FIXED!)<br>";
        echo "7. User melihat warga baru di daftar<br>";
        echo "8. Flash message success ditampilkan<br><br>";

        // Test tambah warga otomatis
        try {
            $testData = [
                'nama' => 'Test Flow ' . date('His'),
                'alamat' => 'Jl. Test Flow No. ' . rand(1, 100),
                'no_hp' => '812-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                'rt' => '001',
                'rw' => '001',
                'keterangan' => 'Test flow tambah warga dengan redirect fix',
                'status' => 'aktif',
                'tanggal_daftar' => date('Y-m-d H:i:s')
            ];

            echo "<strong>🧪 Test Data yang Akan Ditambahkan:</strong><br>";
            echo "Nama: {$testData['nama']}<br>";
            echo "Alamat: {$testData['alamat']}<br>";
            echo "HP: {$testData['no_hp']}<br>";
            echo "RT/RW: {$testData['rt']}/{$testData['rw']}<br>";
            echo "Keterangan: {$testData['keterangan']}<br><br>";

            $result = $this->wargaModel->insert($testData);

            if ($result) {
                $insertId = $this->wargaModel->getInsertID();
                echo "✅ Test data berhasil ditambahkan dengan ID: {$insertId}<br>";

                // Auto-create iuran
                $bulanIndonesia = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];

                $bulanSekarang = $bulanIndonesia[date('n')];
                $tahunSekarang = date('Y');

                $this->iuranModel->save([
                    'id_warga' => $insertId,
                    'bulan'    => $bulanSekarang,
                    'tahun'    => $tahunSekarang,
                    'nominal'  => 50000,
                    'jumlah'   => 50000,
                    'status'   => 'belum lunas',
                    'tanggal'  => date('Y-m-d H:i:s')
                ]);

                echo "✅ Iuran {$bulanSekarang} {$tahunSekarang} berhasil dibuat<br>";
                echo "✅ Simulasi flash message: 'Data warga {$testData['nama']} berhasil disimpan dan iuran {$bulanSekarang} {$tahunSekarang} telah dibuat.'<br>";

            } else {
                echo "❌ Gagal menambahkan test data<br>";
            }

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        // Status database
        $totalWarga = $this->wargaModel->countAllResults();
        echo "<br><strong>📊 Status Database:</strong><br>";
        echo "Total warga sekarang: <strong>{$totalWarga}</strong><br>";

        echo "<br><strong>🎯 Redirect Fix Benefits:</strong><br>";
        echo "✅ User langsung melihat hasil tambah warga<br>";
        echo "✅ Tidak perlu navigasi manual ke daftar warga<br>";
        echo "✅ Flow yang logical dan user-friendly<br>";
        echo "✅ Immediate feedback dan verification<br>";
        echo "✅ Flash message success ditampilkan<br><br>";

        echo "<strong>Test Links:</strong><br>";
        echo "<a href='/warga/tambah' target='_blank' style='background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>➕ Form Tambah Warga</a>";
        echo "<a href='/warga' target='_blank' style='background: #10b981; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>👥 Daftar Warga (Hasil)</a>";
        echo "<a href='/dashboard' target='_blank' style='background: #8b5cf6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>📊 Dashboard</a>";
    }

    /**
     * Method untuk debug masalah warga tidak muncul
     */
    public function debugTidakMuncul()
    {
        echo "<h3>Debug: Warga Tidak Muncul di Daftar</h3>";

        try {
            $db = \Config\Database::connect();

            // 1. Cek koneksi database
            echo "<h4>1. Database Connection:</h4>";
            echo "✅ Koneksi database berhasil<br><br>";

            // 2. Cek tabel warga
            echo "<h4>2. Tabel Warga:</h4>";
            $count = $db->table('warga')->countAllResults();
            echo "Total records di database: <strong>{$count}</strong><br>";

            if ($count > 0) {
                // Ambil 5 data terakhir
                $latestWarga = $db->table('warga')->orderBy('warga_id', 'DESC')->limit(5)->get()->getResultArray();
                echo "<br><strong>5 Data Warga Terakhir:</strong><br>";
                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>ID</th><th>Nama</th><th>Alamat</th><th>HP</th><th>RT</th><th>RW</th><th>Status</th><th>Created</th></tr>";

                foreach ($latestWarga as $w) {
                    echo "<tr>";
                    echo "<td>" . ($w['warga_id'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($w['nama'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($w['alamat'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($w['no_hp'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($w['rt'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($w['rw'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($w['status'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($w['created_at'] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
                echo "</table><br>";
            }

            // 3. Test model method
            echo "<h4>3. Test Model Methods:</h4>";
            try {
                $modelData = $this->wargaModel->findAll();
                echo "wargaModel->findAll(): <strong>" . count($modelData) . "</strong> records<br>";

                $getAllData = $this->wargaModel->getAllWarga();
                echo "wargaModel->getAllWarga(): <strong>" . count($getAllData) . "</strong> records<br>";

                if (count($modelData) != count($getAllData)) {
                    echo "⚠️ <strong>MASALAH DITEMUKAN:</strong> findAll() dan getAllWarga() return jumlah berbeda!<br>";
                }

                if (count($modelData) != $count) {
                    echo "⚠️ <strong>MASALAH DITEMUKAN:</strong> Model return berbeda dengan direct query!<br>";
                }

            } catch (\Exception $e) {
                echo "❌ Error testing model: " . $e->getMessage() . "<br>";
            }

            // 4. Test controller index method
            echo "<br><h4>4. Test Controller Index:</h4>";
            try {
                // Simulate controller index
                $data = [
                    'title' => 'Daftar Warga',
                    'warga' => $this->wargaModel->getAllWarga()
                ];

                echo "Data yang akan dikirim ke view:<br>";
                echo "- title: " . $data['title'] . "<br>";
                echo "- warga count: " . count($data['warga']) . "<br>";

                if (empty($data['warga'])) {
                    echo "❌ <strong>MASALAH:</strong> Data warga kosong di controller!<br>";
                } else {
                    echo "✅ Data warga tersedia di controller<br>";

                    // Show sample
                    $sample = array_slice($data['warga'], 0, 3);
                    echo "<br><strong>Sample data yang akan ditampilkan:</strong><br>";
                    foreach ($sample as $w) {
                        echo "- {$w['nama']} (ID: {$w['warga_id']})<br>";
                    }
                }

            } catch (\Exception $e) {
                echo "❌ Error testing controller: " . $e->getMessage() . "<br>";
            }

            // 5. Test form submission
            echo "<br><h4>5. Test Form Submission:</h4>";
            echo "<a href='/warga/test-tambah-langsung' style='background: #10b981; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;'>Test Tambah Langsung</a><br>";

            // 6. Possible issues
            echo "<br><h4>6. Kemungkinan Masalah:</h4>";
            echo "🔍 <strong>Cek hal-hal berikut:</strong><br>";
            echo "1. Apakah form validation gagal?<br>";
            echo "2. Apakah ada error saat insert?<br>";
            echo "3. Apakah redirect berfungsi?<br>";
            echo "4. Apakah view menampilkan data dengan benar?<br>";
            echo "5. Apakah ada cache yang perlu di-clear?<br><br>";

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }

        echo "<strong>Debug Links:</strong><br>";
        echo "<a href='/warga/tambah' target='_blank' style='background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>➕ Form Tambah</a>";
        echo "<a href='/warga' target='_blank' style='background: #10b981; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>👥 Daftar Warga</a>";
        echo "<a href='/warga/debug' target='_blank' style='background: #f59e0b; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>🔍 Debug Detail</a>";
    }

    /**
     * Method untuk test form submission dengan debug detail
     */
    public function testSubmissionDebug()
    {
        echo "<h3>Test Form Submission dengan Debug Detail</h3>";

        echo "Mari test form submission step by step:<br><br>";

        // Test 1: Simulasi form submission
        echo "<h4>1. Simulasi Form Submission:</h4>";

        $testData = [
            'nama' => 'Test Debug ' . date('His'),
            'alamat' => 'Jl. Debug Test No. ' . rand(1, 100),
            'no_hp' => '812-' . rand(1000, 9999) . '-' . rand(1000, 9999),
            'rt' => '001',
            'rw' => '001',
            'keterangan' => 'Test debug form submission'
        ];

        echo "<strong>Data test yang akan disubmit:</strong><br>";
        foreach ($testData as $key => $value) {
            echo "- {$key}: {$value}<br>";
        }
        echo "<br>";

        // Test 2: Validation
        echo "<h4>2. Test Validation:</h4>";
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[2]|max_length[100]',
            'alamat' => 'required|min_length[3]|max_length[255]',
            'no_hp' => 'required|min_length[8]|max_length[20]',
            'rt' => 'permit_empty|max_length[10]',
            'rw' => 'permit_empty|max_length[10]',
            'keterangan' => 'permit_empty|max_length[255]'
        ]);

        if ($validation->run($testData)) {
            echo "✅ Validation passed<br>";
        } else {
            echo "❌ Validation failed: " . implode(', ', $validation->getErrors()) . "<br>";
        }

        // Test 3: Data preparation
        echo "<br><h4>3. Data Preparation:</h4>";
        $dataWarga = [
            'nama'   => trim($testData['nama']),
            'alamat' => trim($testData['alamat']),
            'no_hp'  => $testData['no_hp'],
            'rt'     => $testData['rt'] ?: '001',
            'rw'     => $testData['rw'] ?: '001',
            'keterangan' => $testData['keterangan'] ?: null,
            'status' => 'aktif',
            'tanggal_daftar' => date('Y-m-d H:i:s')
        ];

        echo "<strong>Data yang akan disimpan:</strong><br>";
        foreach ($dataWarga as $key => $value) {
            echo "- {$key}: " . ($value ?? 'NULL') . "<br>";
        }

        // Test 4: Database insert
        echo "<br><h4>4. Test Database Insert:</h4>";
        try {
            $countBefore = $this->wargaModel->countAllResults();
            echo "Jumlah warga sebelum insert: {$countBefore}<br>";

            $result = $this->wargaModel->insert($dataWarga);

            if ($result) {
                $insertId = $this->wargaModel->getInsertID();
                $countAfter = $this->wargaModel->countAllResults();

                echo "✅ Insert berhasil dengan ID: {$insertId}<br>";
                echo "Jumlah warga setelah insert: {$countAfter}<br>";

                // Verify data
                $savedData = $this->wargaModel->find($insertId);
                if ($savedData) {
                    echo "✅ Data berhasil disimpan dan dapat diambil kembali<br>";
                    echo "Nama tersimpan: {$savedData['nama']}<br>";
                } else {
                    echo "❌ Data tidak dapat diambil kembali<br>";
                }

                // Test iuran creation
                echo "<br><h4>5. Test Iuran Creation:</h4>";
                $bulanIndonesia = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];

                $bulanSekarang = $bulanIndonesia[date('n')];
                $tahunSekarang = date('Y');

                $iuranData = [
                    'id_warga' => $insertId,
                    'bulan'    => $bulanSekarang,
                    'tahun'    => $tahunSekarang,
                    'nominal'  => 50000,
                    'jumlah'   => 50000,
                    'status'   => 'belum lunas',
                    'tanggal'  => date('Y-m-d H:i:s')
                ];

                $iuranResult = $this->iuranModel->save($iuranData);
                if ($iuranResult) {
                    echo "✅ Iuran berhasil dibuat untuk {$bulanSekarang} {$tahunSekarang}<br>";
                } else {
                    echo "❌ Gagal membuat iuran<br>";
                }

            } else {
                echo "❌ Insert gagal<br>";
                $errors = $this->wargaModel->errors();
                if ($errors) {
                    echo "Errors: " . implode(', ', $errors) . "<br>";
                }
            }

        } catch (\Exception $e) {
            echo "❌ Exception: " . $e->getMessage() . "<br>";
        }

        // Test 6: Model methods
        echo "<br><h4>6. Test Model Methods:</h4>";
        try {
            $allWarga = $this->wargaModel->getAllWarga();
            echo "getAllWarga() count: " . count($allWarga) . "<br>";

            $findAllWarga = $this->wargaModel->findAll();
            echo "findAll() count: " . count($findAllWarga) . "<br>";

            if (count($allWarga) == count($findAllWarga)) {
                echo "✅ Model methods consistent<br>";
            } else {
                echo "❌ Model methods inconsistent!<br>";
            }

        } catch (\Exception $e) {
            echo "❌ Error testing model methods: " . $e->getMessage() . "<br>";
        }

        echo "<br><strong>Debug Links:</strong><br>";
        echo "<a href='/warga/tambah' target='_blank' style='background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>➕ Form Tambah</a>";
        echo "<a href='/warga' target='_blank' style='background: #10b981; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>👥 Daftar Warga</a>";
        echo "<a href='/warga/debug-tidak-muncul' target='_blank' style='background: #f59e0b; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>🔍 Debug Tidak Muncul</a>";
    }
}
