public function simpan()
{
    $this->wargaModel->save([
        'nama' => $this->request->getPost('nama'),
        'alamat' => $this->request->getPost('alamat'),
        'no_hp' => $this->request->getPost('no_hp'),
    ]);

    $idWargaBaru = $this->wargaModel->getInsertID();

    // Tambahkan iuran otomatis untuk warga baru
    $this->iuranModel->save([
        'id_warga' => $idWargaBaru,
        'bulan' => date('F'),
        'tahun' => date('Y'),
        'jumlah' => 50000,
        'status' => 'Belum Lunas'
    ]);

    return redirect()->to('/warga');
}
