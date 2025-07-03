<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Laporan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f3f4f6;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #111827;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #374151;
        }

        input[type="date"],
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-submit {
            background-color: #3b82f6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background-color: #2563eb;
        }

        .back-link {
            text-align: center;
            margin-top: 18px;
        }

        .back-link a {
            text-decoration: none;
            color: #3b82f6;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2><i class="fas fa-file-alt"></i> Buat Laporan Keuangan</h2>

        <form action="<?= base_url('laporan/proses') ?>" method="post">
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required>
            </div>

            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" required>
            </div>

            <div class="form-group">
                <label for="jenis">Jenis Transaksi</label>
                <select name="jenis" id="jenis">
                    <option value="">Semua</option>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori">
                    <option value="">Semua</option>
                    <option value="iuran">Iuran</option>
                    <option value="kegiatan">Kegiatan</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Tampilkan Laporan</button>
        </form>

        <div class="back-link">
            <a href="<?= base_url('dashboard') ?>">&larr; Kembali ke Dashboard</a>
        </div>
    </div>

</body>
</html>
