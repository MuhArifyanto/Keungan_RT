<?= $this->include('layout/header') ?>

<h1>Laporan Keuangan</h1>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($laporan): 
            $no = 1;
            foreach ($laporan as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($row['tanggal']) ?></td>
                <td><?= esc($row['tipe']) ?></td>
                <td><?= esc($row['keterangan']) ?></td>
                <td>Rp <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="5" class="text-center">Data laporan kosong</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->include('layout/footer') ?>
