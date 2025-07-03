<h2>Tambah Transaksi</h2>

<form action="<?= base_url('transaksi/store') ?>" method="post">
    <p>
        <label>Nama Transaksi:</label><br>
        <input type="text" name="nama_transaksi" required>
    </p>
    <p>
        <label>Jumlah:</label><br>
        <input type="number" name="jumlah" required>
    </p>
    <p>
        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" required>
    </p>
    <button type="submit">Simpan</button>
</form>
