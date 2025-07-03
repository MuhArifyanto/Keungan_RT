<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial;
            background: #f3f4f6;
            padding: 40px;
        }

        .profile-card {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
        }

        .profile-info {
            margin-top: 20px;
        }

        .profile-info p {
            margin: 10px 0;
            font-size: 16px;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 25px;
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #1e40af;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <h2>Profil Pengguna</h2>
        <div class="profile-info">
            <p><strong>Nama:</strong> <?= esc($user['nama']) ?></p>
            <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
            <p><strong>Username:</strong> <?= esc($user['username']) ?></p>
        </div>
        <a href="<?= base_url('dashboard') ?>" class="btn-back">← Kembali ke Dashboard</a>
    </div>
</body>
</html>
