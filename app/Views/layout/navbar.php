<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= $title ?? 'Keuangan RT' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 220px;
            background-color: #f8f9fa;
            padding: 1rem;
            border-right: 1px solid #ddd;
            height: 100vh;
        }
        .content {
            flex-grow: 1;
            padding: 2rem;
        }
        .sidebar a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="mb-4 text-primary">📊 Keuangan RT</h4>

    <a href="/" class="text-dark">🏠 Dashboard</a>
    <a href="/warga" class="text-dark">🧑‍🤝‍🧑 Data Warga</a>
    <a href="/iuran" class="text-dark">💰 Data Iuran</a>
    <a href="/transaksi" class="text-dark">📄 Transaksi</a>
    <a href="/profile" class="text-dark">👤 Profil</a>

    <?php if (session()->has('logged_in') && session()->get('logged_in') === true): ?>
        <a href="<?= base_url('logout') ?>" class="text-danger">🔓 Logout</a>
    <?php else: ?>
        <a href="<?= base_url('login') ?>" class="text-primary">🔐 Login</a>
    <?php endif; ?>
</div>

<!-- Main Content -->
<div class="content">
    <!-- Konten halaman lain akan dimuat di sini -->
