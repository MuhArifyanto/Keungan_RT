<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Bulan Ini - Keuangan RT</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #334155;
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: #3b82f6;
            color: white;
            padding: 24px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            border: none;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
            color: white;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            color: white;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
            color: white;
        }

        .content {
            padding: 32px;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            font-size: 14px;
        }

        .table thead {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .table thead th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .badge.income {
            background: #dcfce7;
            color: #166534;
        }

        .badge.expense {
            background: #fee2e2;
            color: #991b1b;
        }

        .amount {
            font-weight: 600;
            font-family: 'Inter', monospace;
        }

        .amount.income {
            color: #059669;
        }

        .amount.expense {
            color: #dc2626;
        }

        .no-data {
            text-align: center;
            padding: 48px 20px;
            color: #64748b;
        }

        .no-data i {
            font-size: 2.5rem;
            margin-bottom: 16px;
            opacity: 0.4;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                border-radius: 8px;
            }

            .header {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }

            .header h1 {
                font-size: 1.25rem;
            }

            .content {
                padding: 20px;
            }

            .table {
                font-size: 13px;
            }

            .table thead th,
            .table tbody td {
                padding: 12px 16px;
            }

            .btn {
                padding: 6px 12px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-calendar-month"></i>
                Transaksi Bulan <?= $bulan ?? date('F Y') ?>
            </h1>
            <div class="header-actions">
                <a href="<?= base_url('transaksi/riwayat') ?>" class="btn btn-success">
                    <i class="fas fa-history"></i>
                    Semua Riwayat
                </a>
                <a href="<?= base_url('transaksi/tambah') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah
                </a>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Transactions Table -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Warga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi)) : ?>
                            <?php foreach ($transaksi as $t) : ?>
                                <tr>
                                    <td>
                                        <span class="badge <?= $t['jenis'] == 'masuk' ? 'income' : 'expense' ?>">
                                            <i class="fas fa-<?= $t['jenis'] == 'masuk' ? 'arrow-up' : 'arrow-down' ?>"></i>
                                            <?= $t['jenis'] == 'masuk' ? 'Masuk' : 'Keluar' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 500;"><?= esc($t['keterangan']) ?></div>
                                        <?php if (!empty($t['kategori'])): ?>
                                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;"><?= esc($t['kategori']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="amount <?= $t['jenis'] == 'masuk' ? 'income' : 'expense' ?>">
                                            Rp <?= number_format($t['jumlah'], 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 500;"><?= date('d M Y', strtotime($t['tanggal'])) ?></div>
                                        <div style="font-size: 12px; color: #64748b;"><?= date('H:i', strtotime($t['tanggal'])) ?></div>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <i class="fas fa-user" style="color: #64748b; font-size: 12px;"></i>
                                            <?= esc($t['nama_warga'] ?? 'Sistem') ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="no-data">
                                    <i class="fas fa-inbox"></i>
                                    <div style="margin-top: 8px; font-weight: 500;">Belum ada transaksi bulan ini</div>
                                    <div style="font-size: 14px; margin-top: 4px;">Mulai tambahkan transaksi untuk melihat data di sini</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
