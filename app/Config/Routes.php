<?php

$routes->get('/', 'Dashboard::index');

// Warga
$routes->group('warga', function($routes){
    $routes->get('/', 'Warga::index');
    $routes->add('create', 'Warga::create');
    $routes->add('edit/(:num)', 'Warga::edit/$1');
    $routes->get('delete/(:num)', 'Warga::delete/$1');
});

// Iuran
$routes->group('iuran', function($routes){
    $routes->get('/', 'Iuran::index');
    $routes->get('bayar', 'Iuran::bayar');
    $routes->post('bayar', 'Iuran::bayar');
    $routes->add('create', 'Iuran::create');
    $routes->add('edit/(:num)', 'Iuran::edit/$1');
    $routes->get('delete/(:num)', 'Iuran::delete/$1');
});

// Laporan
$routes->get('laporan', 'Laporan::index');
$routes->get('report', 'Report::index');

// Auth & User
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::doLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::saveRegister');
$routes->get('/profile', 'User::profile');
$routes->get('/warga', 'Warga::index');
$routes->get('/transaksi', 'Transaksi::index');
$routes->get('/transaksi/riwayat', 'Transaksi::riwayat');
$routes->get('/transaksi/tambah', 'Transaksi::tambah');
$routes->get('/iuran/bayar', 'Iuran::bayar');
$routes->get('/warga/tambah', 'Warga::tambah');
$routes->get('/laporan', 'Laporan::index');
$routes->get('/pengeluaran/tambah', 'Pengeluaran::tambah');
$routes->get('/pengaturan', 'Pengaturan::index');
$routes->get('laporan/buat', 'Laporan::buat');
$routes->post('laporan/proses', 'Laporan::proses');
$routes->get('laporan/proses', 'Laporan::prosesGet');
$routes->get('laporan/hasil', 'Laporan::hasil');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('debug', 'Dashboard::debug');
$routes->get('cleanup', 'Dashboard::cleanup');
$routes->get('checkdb', 'Dashboard::checkdb');
$routes->get('addtest', 'Dashboard::addtest');
$routes->get('testpay', 'Dashboard::testpay');
$routes->get('testbayar', 'Dashboard::testbayar');
$routes->get('testform', 'Dashboard::testform');
$routes->get('testpayment', 'Dashboard::testpayment');
$routes->get('formtest', 'Dashboard::formtest');
$routes->get('testlaporan', 'Dashboard::testlaporan');
$routes->get('testlaporanhasil', 'Dashboard::testlaporanhasil');
$routes->get('testlaporanproses', 'Dashboard::testlaporanproses');
$routes->get('testpaymentnew', 'Dashboard::testpaymentnew');
$routes->get('fixtimestamp', 'Dashboard::fixtimestamp');
$routes->get('testpaymenttime', 'Dashboard::testpaymenttime');
$routes->get('createsampledata', 'Dashboard::createsampledata');
$routes->get('testrealtimepayment', 'Dashboard::testrealtimepayment');
$routes->get('debugtransaksi', 'Dashboard::debugtransaksi');
$routes->get('debugtabel', 'Dashboard::debugtabel');
$routes->get('testpaymentdashboard', 'Dashboard::testpaymentdashboard');
$routes->get('debugiuran', 'Dashboard::debugiuran');
$routes->get('createiuranbulanini', 'Dashboard::createiuranbulanini');
$routes->get('createstatistik2025', 'Dashboard::createstatistik2025');
$routes->get('debugstatistik2025', 'Dashboard::debugstatistik2025');
$routes->get('createtrenddata', 'Dashboard::createtrenddata');
$routes->get('debugtrend', 'Dashboard::debugtrend');
$routes->get('testpengeluaran', 'Dashboard::testpengeluaran');
$routes->get('debugtabeltransaksi', 'Dashboard::debugtabeltransaksi');
$routes->get('testpengeluaranbaru', 'Dashboard::testpengeluaranbaru');
$routes->get('testlaporankeuangan', 'Dashboard::testlaporankeuangan');
$routes->get('debuglinechart', 'Dashboard::debuglinechart');
$routes->get('testformlaporanbaru', 'Dashboard::testformlaporanbaru');

// Profile routes
$routes->get('profile', 'Profile::index');
$routes->post('profile/update', 'Profile::update');
$routes->get('testprofile', 'Dashboard::testprofile');
$routes->get('debugchartbulanini', 'Dashboard::debugchartbulanini');
$routes->get('addsamplebulanini', 'Dashboard::addsamplebulanini');

// Transaksi routes
$routes->post('transaksi/hapus-semua', 'Transaksi::hapusSemua');
$routes->post('transaksi/hapus-semua-alt', 'Transaksi::hapusSemuaAlt');
$routes->get('transaksi/debug', 'Transaksi::debug');
$routes->post('transaksi/test-hapus', 'Transaksi::testHapus');
$routes->get('transaksi/add-sample', 'Transaksi::addSample');
$routes->get('transaksi/test-hapus-langsung', 'Transaksi::testHapusLangsung');
$routes->get('transaksi/status-hapus', 'Transaksi::statusHapus');
$routes->get('transaksi/fix-schema', 'Transaksi::fixSchema');
$routes->get('transaksi/test-sql-fix', 'Transaksi::testSqlFix');
$routes->get('transaksi/debug-hapus', 'Transaksi::debugHapus');
$routes->post('transaksi/simpan', 'Transaksi::simpan');
$routes->get('transaksi/test-form-submit', 'Transaksi::testFormSubmit');
$routes->get('warga/test-form-submit', 'Warga::testFormSubmit');
$routes->get('warga/add-sample', 'Warga::addSampleWarga');
$routes->get('warga/add-sample', 'Warga::addSampleWarga');
$routes->get('warga/debug', 'Warga::debugWarga');
$routes->get('warga/fix-database', 'Warga::fixDatabaseStructure');
$routes->get('warga/test-tambah-langsung', 'Warga::testTambahWargaLangsung');
$routes->get('warga/debug-fixed', 'Warga::debugWargaFixed');
$routes->get('warga/test-flow-tambah', 'Warga::testFlowTambahWarga');
$routes->get('warga/debug-tidak-muncul', 'Warga::debugTidakMuncul');
$routes->get('warga/test-submission-debug', 'Warga::testSubmissionDebug');
$routes->get('testhapusriwayat', 'Dashboard::testhapusriwayat');
$routes->get('testhapusfix', 'Dashboard::testhapusfix');
$routes->get('testfixidwarga', 'Dashboard::testfixidwarga');
$routes->get('summaryfixall', 'Dashboard::summaryfixall');
$routes->get('testfixakses', 'Dashboard::testfixakses');
$routes->get('testtambahtransaksi', 'Dashboard::testtambahtransaksi');
$routes->get('testtambahwarga', 'Dashboard::testtambahwarga');
$routes->get('testdaftarwarga', 'Dashboard::testdaftarwarga');
$routes->get('testfixdatawarga', 'Dashboard::testfixdatawarga');
$routes->get('testfinalfixwarga', 'Dashboard::testfinalfixwarga');
$routes->get('testfixdebugwarga', 'Dashboard::testfixdebugwarga');
$routes->get('testfixredirectwarga', 'Dashboard::testfixredirectwarga');
$routes->get('testfinalfixwargamuncul', 'Dashboard::testfinalfixwargamuncul');
$routes->get('testfixvalidationalamat', 'Dashboard::testfixvalidationalamat');
$routes->get('testfixprofile', 'Dashboard::testfixprofile');
$routes->get('testfixemailprofile', 'Dashboard::testfixemailprofile');
$routes->get('testregistersederhana', 'Dashboard::testregistersederhana');
$routes->get('testfixtransaksi', 'Dashboard::testfixtransaksi');
$routes->get('testrapihkantransaksi', 'Dashboard::testrapihkantransaksi');
$routes->get('testsederhanakantrx', 'Dashboard::testsederhanakantrx');
$routes->get('testfixbackground', 'Dashboard::testfixbackground');
$routes->post('warga/simpan', 'Warga::simpan');
$routes->get('pengeluaran/catat', 'Pengeluaran::catat');
$routes->post('pengeluaran/simpan', 'Pengeluaran::simpan');
$routes->get('pengguna/profil', 'Pengguna::profil');
$routes->get('transaksi/riwayat', 'Transaksi::riwayat');
$routes->post('/user/simpan', 'User::simpan');
$routes->get('/user/profile', 'User::profile');
$routes->post('/user/simpan', 'User::simpan');


