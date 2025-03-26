<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $jabatan = $_POST['jabatan'] ?? '';
    $tanggal = $_POST['tanggal'] ?? '';
    $imageData = $_POST['imageData'] ?? '';

    if (!empty($nama) && !empty($jabatan) && !empty($tanggal) && !empty($imageData)) {
        $tanggalFormat = date("Y-m-d", strtotime($tanggal));

        $namaFile = strtolower(str_replace(' ', '_', $nama)) . "_"
                  . strtolower(str_replace(' ', '_', $jabatan)) . "_"
                  . "$tanggalFormat.png";

        $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $imageData);
        $imageBinary = base64_decode($imageData);

        $folder = 'foto/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $filePath = $folder . $namaFile;
        if (file_put_contents($filePath, $imageBinary)) {
            $dataFile = 'absensi.json';
            $newData = [
                'nama' => htmlspecialchars($nama),
                'jabatan' => htmlspecialchars($jabatan),
                'tanggal' => $tanggalFormat,
                'foto' => $filePath
            ];

            $dataList = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
            $dataList[] = $newData;
            file_put_contents($dataFile, json_encode($dataList, JSON_PRETTY_PRINT));

            echo "<script>
                alert('✅ Absensi berhasil!');
                window.location.href='list.php';
            </script>";
        } else {
            echo "<script>
                alert('❌ Absensi gagal!');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('⚠️ Data tidak lengkap! Pastikan semua input sudah diisi.');
            window.history.back();
        </script>";
    }
} else {
    echo "<script>
        alert('⛔ Akses ditolak!');
        window.location.href='index.php';
    </script>";
}
?>
