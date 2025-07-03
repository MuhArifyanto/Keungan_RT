<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi RT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            max-width: 1200px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        .header h2 {
            color: #1e293b;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .table thead {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
        }
        .table thead th {
            border: none;
            font-weight: 600;
            padding: 16px 12px;
        }
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }
        .btn-secondary {
            background: #6b7280;
            border: none;
        }
        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 12px;
            border: none;
            padding: 20px;
        }
        .badge {
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 20px;
        }
        .actions-bottom {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 20px;
            }
            .header {
                flex-direction: column;
                align-items: stretch;
            }
            .header-actions {
                justify-content: center;
            }
            .actions-bottom {
                flex-direction: column;
                align-items: stretch;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header with Actions -->
    <div class="header">
        <h2>
            <i class="fas fa-history"></i>
            Riwayat Transaksi
        </h2>
        <div class="header-actions">
            <a href="<?= base_url('transaksi') ?>" class="btn btn-primary">
                <i class="fas fa-calendar-month"></i>
                Transaksi Bulan Ini
            </a>
            <?php if (!empty($transaksi)) : ?>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash-alt"></i>
                    Hapus Semua Riwayat
                </button>
            <?php endif; ?>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Table Content -->
    <?php if (!empty($transaksi)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Warga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($transaksi as $t) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($t['tanggal'])) ?></td>
                            <td>
                                <span class="badge bg-<?= $t['jenis'] == 'masuk' ? 'success' : 'danger' ?>">
                                    <?= $t['jenis'] == 'masuk' ? 'Pemasukan' : 'Pengeluaran' ?>
                                </span>
                            </td>
                            <td><?= esc($t['kategori'] ?? '-') ?></td>
                            <td>Rp <?= number_format($t['jumlah'], 0, ',', '.') ?></td>
                            <td><?= esc($t['keterangan']) ?></td>
                            <td><?= esc($t['nama_warga'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Summary Info -->
        <div class="actions-bottom">
            <div>
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i>
                    Total <?= count($transaksi) ?> transaksi ditemukan
                </small>
            </div>
        </div>
    <?php else : ?>
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
            <h5>Belum Ada Data Transaksi</h5>
            <p class="mb-0">Riwayat transaksi akan muncul setelah ada pembayaran iuran atau pengeluaran.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle"></i>
                    Konfirmasi Hapus Riwayat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h5>Apakah Anda yakin?</h5>
                    <p class="text-muted">
                        Tindakan ini akan menghapus <strong>SEMUA</strong> riwayat transaksi secara permanen.
                        Data yang sudah dihapus tidak dapat dikembalikan.
                    </p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Peringatan:</strong> Pastikan Anda sudah membuat backup data jika diperlukan.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Batal
                </button>
                <form action="<?= base_url('transaksi/hapus-semua-alt') ?>" method="post" style="display: inline;" id="deleteForm">
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash-alt"></i>
                        Ya, Hapus Semua
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteForm');
        const confirmButton = document.getElementById('confirmDelete');

        if (deleteForm && confirmButton) {
            deleteForm.addEventListener('submit', function(e) {
                // Prevent double submission
                if (confirmButton.disabled) {
                    e.preventDefault();
                    return false;
                }

                // Show loading state
                confirmButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
                confirmButton.disabled = true;

                // Set timeout to re-enable button if something goes wrong
                setTimeout(function() {
                    if (confirmButton.disabled) {
                        confirmButton.innerHTML = '<i class="fas fa-trash-alt"></i> Ya, Hapus Semua';
                        confirmButton.disabled = false;
                    }
                }, 10000); // 10 seconds timeout
            });
        }
    });
</script>
</body>
</html>
