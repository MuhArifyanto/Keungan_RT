<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Laporan Keuangan</title>
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
            max-width: 1200px;
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
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .summary-card.income {
            border-left: 4px solid #10b981;
        }

        .summary-card.expense {
            border-left: 4px solid #ef4444;
        }

        .summary-card.total {
            border-left: 4px solid #3b82f6;
        }

        .summary-card h3 {
            font-size: 0.9rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .summary-card .amount {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .summary-card.income .amount {
            color: #10b981;
        }

        .summary-card.expense .amount {
            color: #ef4444;
        }

        .summary-card.total .amount {
            color: #3b82f6;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        .table-header {
            background: #f8fafc;
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-header h2 {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            color: #1e293b;
        }

        tr:hover {
            background: #f8fafc;
        }

        .amount-income {
            color: #10b981;
            font-weight: 600;
        }

        .amount-expense {
            color: #ef4444;
            font-weight: 600;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.income {
            background: #dcfce7;
            color: #166534;
        }

        .badge.expense {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #374151;
        }

        .empty-state p {
            font-size: 1.1rem;
        }

        .actions {
            margin-top: 40px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
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
                font-size: 2rem;
                flex-direction: column;
                gap: 10px;
            }

            .content {
                padding: 20px;
            }

            .summary-cards {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-chart-line"></i>
                Hasil Laporan Keuangan
            </h1>
            <p>Laporan transaksi berdasarkan filter yang dipilih</p>
        </div>

        <!-- Content -->
        <div class="content">
            <?php
            // Hitung ringkasan
            $totalIncome = 0;
            $totalExpense = 0;
            $totalTransactions = 0;

            if (!empty($laporan)) {
                foreach ($laporan as $item) {
                    $totalTransactions++;
                    if ($item['jenis'] == 'masuk' || $item['jenis'] == 'pemasukan') {
                        $totalIncome += $item['jumlah'];
                    } else {
                        $totalExpense += $item['jumlah'];
                    }
                }
            }

            $netAmount = $totalIncome - $totalExpense;
            ?>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="summary-card income">
                    <h3>Total Pemasukan</h3>
                    <div class="amount">Rp <?= number_format($totalIncome, 0, ',', '.') ?></div>
                    <small><?= $totalTransactions > 0 ? round(($totalIncome / ($totalIncome + $totalExpense)) * 100, 1) : 0 ?>% dari total</small>
                </div>

                <div class="summary-card expense">
                    <h3>Total Pengeluaran</h3>
                    <div class="amount">Rp <?= number_format($totalExpense, 0, ',', '.') ?></div>
                    <small><?= $totalTransactions > 0 ? round(($totalExpense / ($totalIncome + $totalExpense)) * 100, 1) : 0 ?>% dari total</small>
                </div>

                <div class="summary-card total">
                    <h3>Saldo Bersih</h3>
                    <div class="amount">Rp <?= number_format($netAmount, 0, ',', '.') ?></div>
                    <small><?= $totalTransactions ?> transaksi total</small>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div class="table-header">
                    <h2>
                        <i class="fas fa-list"></i>
                        Detail Transaksi
                    </h2>
                </div>

                <?php if (!empty($laporan)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($laporan as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($item['tanggal'])) ?></td>
                                    <td>
                                        <?php if ($item['jenis'] == 'masuk' || $item['jenis'] == 'pemasukan'): ?>
                                            <span class="badge income">Pemasukan</span>
                                        <?php else: ?>
                                            <span class="badge expense">Pengeluaran</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['keterangan']) ?></td>
                                    <td>
                                        <?php if ($item['jenis'] == 'masuk' || $item['jenis'] == 'pemasukan'): ?>
                                            <span class="amount-income">+ Rp <?= number_format($item['jumlah'], 0, ',', '.') ?></span>
                                        <?php else: ?>
                                            <span class="amount-expense">- Rp <?= number_format($item['jumlah'], 0, ',', '.') ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>Tidak Ada Data</h3>
                        <p>Tidak ada transaksi yang ditemukan berdasarkan filter yang dipilih.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Actions -->
            <div class="actions">
                <a href="<?= base_url('laporan/buat') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Buat Laporan Baru
                </a>
                
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i>
                    Cetak Laporan
                </button>
                
                <a href="<?= base_url('dashboard') ?>" class="btn btn-success">
                    <i class="fas fa-home"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        // Print styles
        window.addEventListener('beforeprint', function() {
            document.body.style.background = 'white';
        });

        window.addEventListener('afterprint', function() {
            document.body.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        });
    </script>
</body>
</html>
