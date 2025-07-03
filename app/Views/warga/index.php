<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Warga RT</title>
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
            max-width: 1200px;
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

        .content {
            padding: 40px;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stats-card {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: var(--radius-md);
            padding: 20px;
            text-align: center;
        }

        .stats-card h3 {
            color: var(--primary-blue);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .stats-card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0;
        }

        .table-container {
            background: var(--bg-primary);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
        }

        .table-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        table th {
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-weight: 600;
            padding: 16px 12px;
            text-align: left;
            border-bottom: 2px solid var(--border-light);
            white-space: nowrap;
        }

        table td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }

        table tbody tr:hover {
            background: var(--bg-secondary);
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
            min-width: 60px;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn {
            padding: 12px 24px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
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
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-secondary);
            border: 2px solid var(--border-light);
        }

        .btn-secondary:hover {
            background: var(--border-light);
            color: var(--text-primary);
            text-decoration: none;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.2rem;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .empty-state p {
            margin-bottom: 20px;
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

            .content {
                padding: 24px;
            }

            .stats-cards {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .table-header {
                padding: 16px;
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            table {
                font-size: 0.8rem;
            }

            table th,
            table td {
                padding: 10px 8px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
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
                    <i class="fas fa-users"></i>
                </div>
                <h1>
                    <i class="fas fa-list-ul"></i>
                    Daftar Warga RT
                </h1>
                <p>Sistem Manajemen Warga RT - Data lengkap warga yang terdaftar</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content">
            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="stats-card">
                    <h3><?= count($warga ?? []) ?></h3>
                    <p>Total Warga Terdaftar</p>
                </div>
                <div class="stats-card">
                    <h3><?= count(array_filter($warga ?? [], function($w) { return ($w['status'] ?? 'aktif') === 'aktif'; })) ?></h3>
                    <p>Warga Aktif</p>
                </div>
                <div class="stats-card">
                    <h3><?= count(array_unique(array_column($warga ?? [], 'rt'))) ?></h3>
                    <p>RT Terdaftar</p>
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-container">
                <div class="table-header">
                    <h3>
                        <i class="fas fa-table"></i>
                        Data Warga RT
                    </h3>
                    <span class="badge badge-info"><?= count($warga ?? []) ?> warga</span>
                </div>

                <div class="table-responsive">
                    <?php if (empty($warga)) : ?>
                        <div class="empty-state">
                            <i class="fas fa-users-slash"></i>
                            <h3>Belum Ada Data Warga</h3>
                            <p>Belum ada warga yang terdaftar dalam sistem. Silakan tambah warga baru untuk memulai.</p>
                            <a href="<?= base_url('warga/tambah') ?>" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i>
                                Tambah Warga Pertama
                            </a>
                        </div>
                    <?php else : ?>
                        <table>
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag"></i> No</th>
                                    <th><i class="fas fa-user"></i> Nama Lengkap</th>
                                    <th><i class="fas fa-map-marker-alt"></i> Alamat</th>
                                    <th><i class="fas fa-phone"></i> No HP</th>
                                    <th><i class="fas fa-home"></i> RT</th>
                                    <th><i class="fas fa-building"></i> RW</th>
                                    <th><i class="fas fa-info-circle"></i> Status</th>
                                    <th><i class="fas fa-sticky-note"></i> Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($warga as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= esc($row['nama']) ?></strong>
                                        </td>
                                        <td><?= esc($row['alamat']) ?></td>
                                        <td>
                                            <a href="tel:+62<?= esc($row['no_hp']) ?>" style="color: var(--primary-blue); text-decoration: none;">
                                                <i class="fas fa-phone-alt"></i>
                                                <?= esc($row['no_hp']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                RT <?= esc($row['rt'] ?? '001') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                RW <?= esc($row['rw'] ?? '001') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $row['status'] ?? 'aktif';
                                            $badgeClass = $status === 'aktif' ? 'badge-success' : 'badge-warning';
                                            ?>
                                            <span class="badge <?= $badgeClass ?>">
                                                <?= ucfirst($status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['keterangan'])): ?>
                                                <span title="<?= esc($row['keterangan']) ?>">
                                                    <?= esc(strlen($row['keterangan']) > 30 ? substr($row['keterangan'], 0, 30) . '...' : $row['keterangan']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span style="color: var(--text-secondary); font-style: italic;">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php endif ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="actions">
                <a href="<?= base_url('warga/tambah') ?>" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Tambah Warga Baru
                </a>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>
