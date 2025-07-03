<?= $this->include('layout/header') ?>

<h1>Data Iuran</h1>
<a href="/iuran/bayar" class="btn btn-primary mb-3">Tambah Iuran</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Warga</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Nominal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($iuran): 
            $no = 1; 
            foreach ($iuran as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($row['nama']) ?></td>
                <td><?= esc($row['bulan']) ?></td>
                <td><?= esc($row['tahun']) ?></td>
                <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                <td><?= esc($row['status']) ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="6" class="text-center">Data iuran kosong</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->include('layout/footer') ?>
