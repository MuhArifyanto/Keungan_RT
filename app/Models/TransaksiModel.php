<?php 
namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'tanggal',
        'jenis',
        'jumlah',
        'keterangan',
        'id_user',
        'id_warga'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    protected $validationRules = [
        'tanggal'     => 'required|valid_date',
        'jenis'       => 'required|in_list[masuk,keluar]',
        'jumlah'      => 'required|numeric|greater_than[0]',
        'keterangan'  => 'permit_empty|string|max_length[255]',
        'id_user'     => 'permit_empty|numeric',
        'id_warga'    => 'permit_empty|numeric',
    ];
    
    protected $validationMessages = [
        'jumlah' => [
            'greater_than' => 'Jumlah transaksi harus lebih besar dari 0'
        ]
    ];
    
    protected $skipValidation = false;

    public function getTransaksi($jenis = null, $tahun = null, $bulan = null, $limit = null)
    {
        $builder = $this->db->table($this->table)
            ->select('transaksi.*, warga.nama as nama_warga, user.nama as nama_user')
            ->join('warga', 'warga.warga_id = transaksi.id_warga AND transaksi.id_warga > 0', 'left')
            ->join('user', 'user.id_user = transaksi.id_user', 'left')
            ->orderBy('transaksi.tanggal', 'DESC');

        if ($jenis) {
            $builder->where('transaksi.jenis', $jenis);
        }

        if ($tahun) {
            $builder->where('YEAR(transaksi.tanggal)', $tahun);
        }

        if ($bulan) {
            $builder->where('MONTH(transaksi.tanggal)', $bulan);
        }

        if ($limit) {
            $builder->limit($limit);
        }

        $results = $builder->get()->getResultArray();

        // Post-process untuk handle nama warga
        foreach ($results as &$row) {
            if ($row['id_warga'] == 0) {
                $row['nama_warga'] = 'Sistem';
            } elseif (empty($row['nama_warga'])) {
                $row['nama_warga'] = '-';
            }
        }

        return $results;
    }

    /**
     * Method sederhana untuk mengambil transaksi terbaru tanpa JOIN
     */
    public function getTransaksiSimple($limit = 5)
    {
        $builder = $this->db->table($this->table)
            ->orderBy('tanggal', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        $transaksi = $builder->get()->getResultArray();

        // Ambil nama warga secara manual
        foreach ($transaksi as &$t) {
            if ($t['id_warga'] && $t['id_warga'] > 0) {
                $warga = $this->db->table('warga')
                    ->where('warga_id', $t['id_warga'])
                    ->get()
                    ->getRowArray();
                $t['nama_warga'] = $warga ? $warga['nama'] : 'Unknown';
            } else {
                $t['nama_warga'] = 'Sistem';
            }
        }

        return $transaksi;
    }

    public function getTotalTransaksi($jenis, $tahun = null, $bulan = null)
    {
        $builder = $this->db->table($this->table)
            ->selectSum('jumlah')
            ->where('jenis', $jenis);

        if ($tahun) {
            $builder->where('YEAR(tanggal)', $tahun);
        }

        if ($bulan) {
            $builder->where('MONTH(tanggal)', $bulan);
        }

        return $builder->get()->getRow()->jumlah ?? 0;
    }

    public function getMonthlyData($tahun, $jenis = 'masuk')
    {
        $data = array_fill(0, 12, 0);

        $builder = $this->db->table($this->table)
            ->select('MONTH(tanggal) as bulan, SUM(jumlah) as total')
            ->where('YEAR(tanggal)', $tahun)
            ->where('jenis', $jenis)
            ->groupBy('MONTH(tanggal)')
            ->orderBy('bulan', 'ASC');

        $results = $builder->get()->getResultArray();

        foreach ($results as $row) {
            $data[$row['bulan'] - 1] = (float)$row['total'];
        }

        return $data;
    }

    public function getRecentTransactions($limit = 5)
    {
        return $this->orderBy('tanggal', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getSaldoKas()
    {
        $pemasukan = $this->where('jenis', 'masuk')
                          ->selectSum('jumlah')
                          ->get()
                          ->getRow()->jumlah ?? 0;

        $pengeluaran = $this->where('jenis', 'keluar')
                            ->selectSum('jumlah')
                            ->get()
                            ->getRow()->jumlah ?? 0;

        return $pemasukan - $pengeluaran;
    }

    public function getByKategori($jenis, $limit = null)
    {
        $builder = $this->db->table($this->table)
            ->select('kategori, SUM(jumlah) as total')
            ->where('jenis', $jenis)
            ->groupBy('kategori')
            ->orderBy('total', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    public function getByWarga($id_warga)
    {
        return $this->where('id_warga', $id_warga)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }

    /**
     * Insert transaksi dengan handling id_warga NULL
     */
    public function insertTransaksi($data)
    {
        // Jika id_warga adalah null atau empty, set ke 0 atau hapus dari data
        if (empty($data['id_warga']) || $data['id_warga'] === null) {
            // Untuk transaksi sistem (pengeluaran umum), gunakan id_warga = 0
            $data['id_warga'] = 0;
        }

        return $this->insert($data);
    }

    /**
     * Method untuk membersihkan data sebelum insert
     */
    protected function cleanDataForInsert($data)
    {
        // Handle id_warga NULL
        if (!isset($data['id_warga']) || $data['id_warga'] === null || $data['id_warga'] === '') {
            $data['id_warga'] = 0; // Default untuk transaksi sistem
        }

        // Handle id_user NULL
        if (!isset($data['id_user']) || $data['id_user'] === null || $data['id_user'] === '') {
            $data['id_user'] = 1; // Default admin user
        }

        return $data;
    }

    /**
     * Method untuk mengambil transaksi bulan ini saja
     */
    public function getTransaksiBulanIni($bulanTahun = null)
    {
        if (!$bulanTahun) {
            $bulanTahun = date('Y-m');
        }

        $builder = $this->db->table($this->table)
            ->select('transaksi.*, warga.nama as nama_warga')
            ->join('warga', 'warga.warga_id = transaksi.id_warga AND transaksi.id_warga > 0', 'left')
            ->where("DATE_FORMAT(transaksi.tanggal, '%Y-%m')", $bulanTahun)
            ->orderBy('transaksi.tanggal', 'DESC');

        $results = $builder->get()->getResultArray();

        // Post-process untuk handle nama warga
        foreach ($results as &$row) {
            if ($row['id_warga'] == 0) {
                $row['nama_warga'] = 'Sistem';
            } elseif (empty($row['nama_warga'])) {
                $row['nama_warga'] = '-';
            }
        }

        return $results;
    }

    /**
     * Method untuk mengambil semua transaksi (untuk riwayat)
     */
    public function getAllTransaksi($limit = null)
    {
        $builder = $this->db->table($this->table)
            ->select('transaksi.*, warga.nama as nama_warga')
            ->join('warga', 'warga.warga_id = transaksi.id_warga AND transaksi.id_warga > 0', 'left')
            ->orderBy('transaksi.tanggal', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        $results = $builder->get()->getResultArray();

        // Post-process untuk handle nama warga
        foreach ($results as &$row) {
            if ($row['id_warga'] == 0) {
                $row['nama_warga'] = 'Sistem';
            } elseif (empty($row['nama_warga'])) {
                $row['nama_warga'] = '-';
            }
        }

        return $results;
    }
}
