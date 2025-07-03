<?= $this->include('layout/header') ?>

<h1><?= isset($warga) ? 'Edit Warga' : 'Tambah Warga' ?></h1>

<form action="" method="post">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" name="nama" id="nama" class="form-control" value="<?= isset($warga) ? esc($warga['nama']) : '' ?>" required>
    </div>
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control" required><?= isset($warga) ? esc($warga['alamat']) : '' ?></textarea>
    </div>
    <div class="mb-3">
        <label for="rt_rw" class="form-label">RT/RW</label>
        <input type="text" name="rt_rw" id="rt_rw" class="form-control" value="<?= isset($warga) ? esc($warga['rt_rw']) : '' ?>" required>
    </div>
    <div class="mb-3">
        <label for="no_hp" class="form-label">No HP</label>
        <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= isset($warga) ? esc($warga['no_hp']) : '' ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="/warga" class="btn btn-secondary">Batal</a>
</form>

<?= $this->include('layout/footer') ?>
