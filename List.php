<?php
$dataFile = 'absensi.json';
$dataList = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card p-4 shadow-lg">
        <h2 class="text-center">Daftar Absensi</h2>
        
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Tanggal</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dataList)) : ?>
                    <?php foreach ($dataList as $data) : ?>
                        <tr>
                            <td><?= htmlspecialchars($data['nama']) ?></td>
                            <td><?= htmlspecialchars($data['jabatan']) ?></td>
                            <td><?= htmlspecialchars($data['tanggal']) ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($data['foto']) ?>" width="100" height="100" class="border rounded">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data absensi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-primary">Kembali</a>
            <a href="index.php" class="btn btn-secondary">Home</a>
        </div>
    </div>
</div>

</body>
</html>
