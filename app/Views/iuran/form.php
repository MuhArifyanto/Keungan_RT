<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran Iuran RT</title>
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
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
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
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
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
                <i class="fas fa-money-bill-wave"></i>
                Form Pembayaran Iuran RT
            </h1>
            <p>Sistem Pencatatan Pembayaran Iuran Warga</p>

            <!-- Info Waktu Saat Ini -->
            <div class="info-time">
                <i class="fas fa-clock"></i>
                <span>Waktu Pembayaran: </span>
                <span id="currentDateTime"></span>
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container">

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (isset($validation) && $validation->getErrors()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($validation->getErrors() as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/iuran/bayar" method="post">
    <?= csrf_field() ?>

            <div class="form-group">
                <label for="id_warga" class="form-label">
                    <i class="fas fa-user"></i> Nama Warga
                </label>
                <select name="id_warga" id="id_warga" class="form-select" required>
                    <option value="">-- Pilih Warga --</option>
                    <?php foreach ($warga as $w): ?>
                     <option value="<?= $w['warga_id'] ?>" <?= isset($iuran['id_warga']) && $iuran['id_warga'] == $w['warga_id'] ? 'selected' : '' ?>>
                            <?= $w['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="bulan" class="form-label">
                    <i class="fas fa-calendar-alt"></i> Bulan
                </label>
                <select name="bulan" id="bulan" class="form-select" required>
                    <?php
                    $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                    foreach ($months as $month): ?>
                        <option value="<?= $month ?>" <?= isset($iuran['bulan']) && $iuran['bulan'] == $month ? 'selected' : '' ?>>
                            <?= $month ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tahun" class="form-label">
                    <i class="fas fa-calendar"></i> Tahun
                </label>
                <input type="number" name="tahun" id="tahun" class="form-control"
                       value="<?= isset($iuran['tahun']) ? $iuran['tahun'] : date('Y') ?>" required min="2020" max="2030">
            </div>

            <div class="form-group">
                <label for="nominal" class="form-label">
                    <i class="fas fa-money-bill"></i> Nominal (Rp)
                </label>
                <input type="number" name="nominal" id="nominal" class="form-control"
                       value="<?= isset($iuran['nominal']) ? $iuran['nominal'] : '5000' ?>" required min="1000" step="1000"
                       placeholder="Masukkan nominal iuran">
            </div>

            <div class="form-group">
                <label for="status" class="form-label">
                    <i class="fas fa-check-circle"></i> Status Pembayaran
                </label>
                <select name="status" id="status" class="form-select" required>
                    <option value="lunas" <?= isset($iuran['status']) && $iuran['status'] == 'lunas' ? 'selected' : 'selected' ?>>✅ Lunas</option>
                    <option value="belum_lunas" <?= isset($iuran['status']) && $iuran['status'] == 'belum_lunas' ? 'selected' : '' ?>>⏳ Belum Lunas</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i>
                    Simpan Pembayaran
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

        // Format input nominal dengan separator ribuan
        document.getElementById('nominal').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value) {
                e.target.value = parseInt(value);
            }
        });

        // Auto-focus ke field pertama
        document.getElementById('id_warga').focus();
    </script>
</body>
</html>
