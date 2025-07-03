<?php

namespace App\Models;

use CodeIgniter\Model;

class WargaModel extends Model
{
    protected $table = 'warga';
    protected $primaryKey = 'warga_id';
    protected $allowedFields = [
        'nama',
        'alamat',
        'no_hp',
        'rt',
        'rw',
        'keterangan',
        'status',
        'tanggal_daftar'
    ];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all warga with proper ordering
     */
    public function getAllWarga()
    {
        return $this->orderBy('nama', 'ASC')->findAll();
    }

    /**
     * Get warga by status
     */
    public function getWargaByStatus($status = 'aktif')
    {
        return $this->where('status', $status)->orderBy('nama', 'ASC')->findAll();
    }
}
