<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Pengeluaran RT</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .header p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .info-time {
            background: rgba(255,255,255,0.1);
            padding: 12px 20px;
            border-radius: 8px;
            margin-top: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .form-container {
            padding: 40px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: #ef4444;
            color: #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            border-color: #10b981;
            color: #059669;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .form-actions {
            margin-top: 30px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 12px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 1.6rem;
                flex-direction: column;
                gap: 10px;
            }

            .form-container {
                padding: 20px;
            }

            .btn {
                width: 100%;
                justify-content: center;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-money-bill-trend-down"></i>
                Catat Pengeluaran RT
            </h1>
            <p>Sistem Pencatatan Pengeluaran Kas RT</p>

            <!-- Info Waktu Saat Ini -->
            <div class="info-time">
                <i class="fas fa-clock"></i>
                <span>Waktu Pencatatan: </span>
                <span id="currentDateTime"></span>
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('pengeluaran/simpan') ?>" method="post">
                <div class="form-group">
                    <label for="tanggal" class="form-label">
                        <i class="fas fa-calendar"></i> Tanggal Pengeluaran
                    </label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                           value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group">
                    <label for="kategori" class="form-label">
                        <i class="fas fa-tags"></i> Kategori Pengeluaran
                    </label>
                    <select name="kategori" id="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Kegiatan RT">Kegiatan RT</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Keamanan">Keamanan</option>
                        <option value="Pemeliharaan">Pemeliharaan</option>
                        <option value="Administrasi">Administrasi</option>
                        <option value="Sosial">Sosial</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jumlah" class="form-label">
                        <i class="fas fa-money-bill"></i> Jumlah Pengeluaran (Rp)
                    </label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                           min="1000" step="1000" placeholder="Masukkan jumlah pengeluaran" required>
                </div>

                <div class="form-group">
                    <label for="keterangan" class="form-label">
                        <i class="fas fa-sticky-note"></i> Keterangan Detail
                    </label>
                    <textarea name="keterangan" id="keterangan" class="form-control"
                              rows="4" placeholder="Jelaskan detail pengeluaran..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-save"></i>
                        Simpan Pengeluaran
                    </button>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Update waktu real-time
        function updateDateTime() {
            const now = new Date();

            // Set timezone ke Indonesia
            const options = {
                timeZone: 'Asia/Jakarta',
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };

            const dateTimeStr = now.toLocaleDateString('id-ID', options);
            document.getElementById('currentDateTime').textContent = dateTimeStr;
        }

        // Jalankan fungsi update waktu
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Auto-focus ke field pertama
        document.getElementById('tanggal').focus();
    </script>
</body>
</html>
