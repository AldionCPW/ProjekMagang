<?php
$dataFile = 'absensi.json';
$dataList = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Hapus data berdasarkan index
        $index = $_POST['index'];
        if (isset($dataList[$index])) {
            unset($dataList[$index]);
            file_put_contents($dataFile, json_encode(array_values($dataList), JSON_PRETTY_PRINT));
        }
    } elseif (isset($_POST['edit'])) {
        // Edit data berdasarkan index
        $index = $_POST['index'];
        $dataList[$index]['nama'] = $_POST['nama'];
        $dataList[$index]['jabatan'] = $_POST['jabatan'];
        $dataList[$index]['tanggal'] = $_POST['tanggal'];

        file_put_contents($dataFile, json_encode($dataList, JSON_PRETTY_PRINT));
    }
    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<div class="container mt-5">
    <div class="card p-4 shadow-lg">
        <h2 class="text-center">Daftar Absensi</h2>

        <table class="table table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Tanggal</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dataList)) : ?>
                    <?php foreach ($dataList as $index => $data) : ?>
                        <tr>
                            <td><?= htmlspecialchars($data['nama']) ?></td>
                            <td><?= htmlspecialchars($data['jabatan']) ?></td>
                            <td><?= htmlspecialchars($data['tanggal']) ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($data['foto']) ?>" width="100" height="100" class="border rounded">
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $index ?>">Edit</button>
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $index ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $index ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $index ?>">Edit Absensi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST">
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Nama:</label>
                                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jabatan:</label>
                                                <select class="form-select" name="jabatan" required>
                                                    <option value="Hyper" <?= ($data['jabatan'] == "Hyper") ? "selected" : "" ?>>Hyper</option>
                                                    <option value="Gold" <?= ($data['jabatan'] == "Gold") ? "selected" : "" ?>>Gold</option>
                                                    <option value="Explaner" <?= ($data['jabatan'] == "Explaner") ? "selected" : "" ?>>Explaner</option>
                                                    <option value="Midlaner" <?= ($data['jabatan'] == "Midlaner") ? "selected" : "" ?>>Midlaner</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal:</label>
                                                <input type="date" name="tanggal" class="form-control" value="<?= htmlspecialchars($data['tanggal']) ?>" required>
                                            </div>
                                            <button type="submit" name="edit" class="btn btn-success w-100">Simpan Perubahan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data absensi</td>
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
