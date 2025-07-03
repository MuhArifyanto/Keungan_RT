<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= $title ?? 'Keuangan RT' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="/">Keuangan RT</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="/warga">Data Warga</a></li>
        <li class="nav-item"><a class="nav-link" href="/iuran">Iuran</a></li>
        <li class="nav-item"><a class="nav-link" href="/laporan">Laporan</a></li>
        <li class="nav-item"><a class="nav-link" href="/report">Report</a></li>
        <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
      </ul>

      <!-- Profile or Login -->
      <ul class="navbar-nav ms-auto">
        <?php if (session()->get('logged_in')) : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
              👤 <?= session()->get('username') ?? 'Profil' ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="/profile">Profil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
          </li>
        <?php else : ?>
          <li class="nav-item"><a class="nav-link" href="/profile">Profile</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
