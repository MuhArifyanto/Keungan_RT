<?php

namespace App\Controllers;
use App\Models\LaporanModel;

class Report extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Export',
            'laporan' => $this->laporanModel->findAll()
        ];
        return view('report/index', $data);
    }

    public function exportPdf()
    {
        // Buat logika export PDF menggunakan Dompdf atau library lain
    }

    public function exportExcel()
    {
        // Buat logika export Excel menggunakan PhpSpreadsheet
    }
}
