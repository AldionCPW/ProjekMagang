<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<?php include 'templates/header.php'; ?>

<div class="container mt-5">
    <div class="card p-4 shadow-lg">
        <h2 class="text-center text-primary">Form Absensi</h2>

        <form id="uploadForm" action="upload.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="mb-3">
                <label class="form-label">Nama:</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan:</label>
                <select class="form-select" name="jabatan" required>
                    <option selected disabled>Pilih Jabatan</option>
                    <option value="Hyper">Hyper</option>
                    <option value="Gold">Gold</option>
                    <option value="Explaner">Explaner</option>
                    <option value="Midlaner">Midlaner</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
            </div>

            <div class="mb-3 text-center">
                <video id="video" class="border rounded" width="320" height="240" autoplay></video>
                <br>
                <button type="button" id="capture" class="btn btn-primary mt-2">Ambil Foto</button>
                <canvas id="canvas" style="display: none;"></canvas>
            </div>

            <div class="mb-3 text-center">
                <img id="photo" width="320" height="240" class="border rounded">
                <input type="hidden" name="imageData" id="imageData">
            </div>

            <button type="submit" class="btn btn-success w-100">Simpan</button>
        </form>
    </div>
</div>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const photo = document.getElementById('photo');
    const captureButton = document.getElementById('capture');
    const imageDataInput = document.getElementById('imageData');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(error => {
            console.error("Akses kamera gagal:", error);
        });

    captureButton.addEventListener('click', () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/png');
        photo.src = imageData;
        imageDataInput.value = imageData;
    });

    function validateForm() {
        if (imageDataInput.value === '') {
            alert('⚠️ Anda belum mengambil foto!');
            return false;
        }
        return true;
    }
</script>

<?php include 'templates/footer.php'; ?>

</body>
</html>
