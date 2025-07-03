<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan Keuangan RT</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #3b82f6;
            --primary-dark: #1e40af;
            --success-green: #10b981;
            --danger-red: #ef4444;
            --warning-yellow: #f59e0b;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-card: #ffffff;
            --border-light: #e2e8f0;
            --border-focus: #3b82f6;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
        }

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
            color: var(--text-primary);
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: var(--bg-card);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 400;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .form-container {
            padding: 40px;
        }

        .alert {
            padding: 16px 20px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: var(--danger-red);
            color: #991b1b;
        }

        .alert-success {
            background: #f0fdf4;
            border-color: var(--success-green);
            color: #166534;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border-light);
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: var(--bg-primary);
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        .btn {
            padding: 14px 28px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-secondary);
            border: 2px solid var(--border-light);
        }

        .btn-secondary:hover {
            background: var(--border-light);
            color: var(--text-primary);
        }

        .form-actions {
            display: flex;
            gap: 16px;
            margin-top: 32px;
        }

        .form-actions .btn {
            flex: 1;
        }

        .info-card {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: var(--radius-md);
            padding: 20px;
            margin-bottom: 24px;
        }

        .info-card h3 {
            color: var(--primary-blue);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 1.8rem;
                flex-direction: column;
                gap: 12px;
            }

            .form-container {
                padding: 24px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="header-content">
                <div class="header-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h1>
                    <i class="fas fa-file-chart-line"></i>
                    Buat Laporan Keuangan
                </h1>
                <p>Sistem Pelaporan Keuangan RT - Generate laporan transaksi dengan filter yang fleksibel</p>
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <!-- Info Card -->
            <div class="info-card">
                <h3>
                    <i class="fas fa-info-circle"></i>
                    Panduan Penggunaan
                </h3>
                <p>Pilih rentang tanggal, jenis transaksi, dan kategori untuk menghasilkan laporan keuangan yang sesuai dengan kebutuhan Anda. Laporan akan menampilkan ringkasan dan detail transaksi.</p>
            </div>

            <!-- Form -->
            <form action="<?= base_url('laporan/proses') ?>" method="post" id="laporanForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="tanggal_mulai" class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Tanggal Mulai
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                               value="<?= date('Y-m-01') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_selesai" class="form-label">
                            <i class="fas fa-calendar-check"></i>
                            Tanggal Selesai
                        </label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                               value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="jenis" class="form-label">
                            <i class="fas fa-exchange-alt"></i>
                            Jenis Transaksi
                        </label>
                        <select name="jenis" id="jenis" class="form-select">
                            <option value="">📊 Semua Transaksi</option>
                            <option value="pemasukan">💰 Pemasukan</option>
                            <option value="pengeluaran">💸 Pengeluaran</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kategori" class="form-label">
                            <i class="fas fa-tags"></i>
                            Kategori
                        </label>
                        <select name="kategori" id="kategori" class="form-select">
                            <option value="">🏷️ Semua Kategori</option>
                            <option value="iuran">🏠 Iuran RT</option>
                            <option value="kegiatan">🎉 Kegiatan</option>
                            <option value="kebersihan">🧹 Kebersihan</option>
                            <option value="keamanan">🛡️ Keamanan</option>
                            <option value="pemeliharaan">🔧 Pemeliharaan</option>
                            <option value="administrasi">📋 Administrasi</option>
                            <option value="sosial">🤝 Sosial</option>
                            <option value="lainnya">📦 Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-chart-line"></i>
                        Generate Laporan
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
        // Form validation dan enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('laporanForm');
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');

            // Validasi tanggal
            function validateDates() {
                const mulai = new Date(tanggalMulai.value);
                const selesai = new Date(tanggalSelesai.value);

                if (mulai > selesai) {
                    tanggalSelesai.setCustomValidity('Tanggal selesai harus setelah tanggal mulai');
                } else {
                    tanggalSelesai.setCustomValidity('');
                }
            }

            tanggalMulai.addEventListener('change', validateDates);
            tanggalSelesai.addEventListener('change', validateDates);

            // Auto-focus ke field pertama
            tanggalMulai.focus();

            // Form submission dengan loading state
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                submitBtn.disabled = true;

                // Reset jika ada error
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            });
        });
    </script>
</body>
</html>
