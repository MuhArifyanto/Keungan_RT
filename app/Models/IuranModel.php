<?php

namespace App\Models;

use CodeIgniter\Model;

class IuranModel extends Model
{
    protected $table = 'iuran';
    protected $primaryKey = 'id_iuran';
    protected $allowedFields = ['id_warga', 'bulan', 'tahun', 'nominal', 'status', 'tanggal'];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'id_warga' => 'required|numeric',
        'bulan' => 'required|string',
        'tahun' => 'required|numeric',
        'nominal' => 'required|numeric|greater_than[0]',
        'status' => 'required|in_list[lunas,belum_lunas]',
        'tanggal' => 'permit_empty|valid_date'
    ];

    /**
     * Ambil semua data iuran beserta nama warga
     */
    public function getAllWithWarga()
    {
        return $this->db->table($this->table)
            ->select('iuran.*, warga.nama')
            ->join('warga', 'warga.warga_id = iuran.id_warga')
            ->get()
            ->getResultArray();
    }

    /**
     * Hitung total seluruh iuran
     */
    public function getTotalIuran()
    {
        $result = $this->selectSum('nominal')->first();
        return $result['nominal'] ?? 0;
    }

    /**
     * Hitung total iuran berdasarkan tahun dan bulan
     */
    public function getTotalIuranByPeriode($bulan, $tahun)
    {
        $result = $this->where(['bulan' => $bulan, 'tahun' => $tahun])
                       ->selectSum('nominal')
                       ->first();
        return $result['nominal'] ?? 0;
    }

    /**
     * Ambil semua iuran dengan status tertentu (default: lunas)
     */
    public function getIuranByStatus($status = 'lunas')
    {
        return $this->where('status', $status)->findAll();
    }

    /**
     * Ambil data iuran berdasarkan bulan dan tahun tertentu
     */
    public function getMonthlyData($bulan, $tahun)
    {
        return $this->db->table($this->table)
            ->select('iuran.*, warga.nama')
            ->join('warga', 'warga.warga_id = iuran.id_warga')
            ->where('iuran.bulan', $bulan)
            ->where('iuran.tahun', $tahun)
            ->get()
            ->getResultArray();
    }

    /**
     * Cek apakah warga sudah bayar iuran bulan tertentu
     */
    public function sudahBayar($id_warga, $bulan, $tahun)
    {
        $result = $this->where([
            'id_warga' => $id_warga,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => 'lunas'
        ])->first();

        return $result !== null;
    }

    /**
     * Ambil data statistik iuran per bulan untuk tahun tertentu
     */
    public function getYearlyStatistics($tahun)
    {
        // Mapping bulan Indonesia ke angka
        $bulanMapping = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
            'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
            'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];

        // Inisialisasi array untuk 12 bulan
        $data = array_fill(0, 12, 0);

        // Query untuk mengambil total iuran per bulan
        $builder = $this->db->table($this->table);
        $builder->select('bulan, SUM(nominal) as total');
        $builder->where('tahun', $tahun);
        $builder->where('status', 'lunas');
        $builder->groupBy('bulan');

        $results = $builder->get()->getResultArray();

        // Masukkan data ke array berdasarkan bulan
        foreach ($results as $row) {
            $bulanNama = $row['bulan'];
            if (isset($bulanMapping[$bulanNama])) {
                $bulanIndex = $bulanMapping[$bulanNama] - 1; // Array index mulai dari 0
                $data[$bulanIndex] = (float)$row['total'];
            }
        }

        return $data;
    }

    /**
     * Ambil detail statistik iuran per bulan untuk tahun tertentu
     */
    public function getDetailedYearlyStatistics($tahun)
    {
        // Mapping bulan Indonesia
        $bulanIndonesia = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $statistics = [];

        foreach ($bulanIndonesia as $bulan) {
            // Hitung total iuran bulan ini
            $builderTotal = $this->db->table($this->table);
            $builderTotal->selectSum('nominal', 'total');
            $builderTotal->where('bulan', $bulan);
            $builderTotal->where('tahun', $tahun);
            $builderTotal->where('status', 'lunas');
            $resultTotal = $builderTotal->get()->getRowArray();

            // Hitung jumlah pembayar bulan ini
            $builderCount = $this->db->table($this->table);
            $builderCount->select('id_warga');
            $builderCount->where('bulan', $bulan);
            $builderCount->where('tahun', $tahun);
            $builderCount->where('status', 'lunas');
            $builderCount->groupBy('id_warga');
            $jumlahPembayar = $builderCount->countAllResults(false);

            $statistics[] = [
                'bulan' => $bulan,
                'total_iuran' => $resultTotal['total'] ?? 0,
                'jumlah_pembayar' => $jumlahPembayar
            ];
        }

        return $statistics;
    }
}
