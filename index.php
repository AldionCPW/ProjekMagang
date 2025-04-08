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

    <!-- Main content -->
    <div class="container mt-5 main-content">
        <div class="row">
            <!-- Section Absensi -->
            <section class="col-md-8">
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
                            <!-- Hapus tombol Mulai Kamera di sini -->
                            <button type="button" id="capture" class="btn btn-primary mt-2" disabled>Ambil Foto</button>
                            <canvas id="canvas" style="display: none;"></canvas>
                        </div>

                        <div class="mb-3 text-center">
                            <img id="photo" width="320" height="240" class="border rounded">
                            <input type="hidden" name="imageData" id="imageData">
                        </div>

                        <button type="submit" class="btn btn-success w-100">Simpan</button>
                    </form>
                </div>
            </section>

            <!-- Section Kamera -->
            <aside class="col-md-4">
                <div class="card p-4 shadow-lg">
                    <h3 class="text-center">Kamera Absensi</h3>
                    <div class="text-center">
                        <video id="videoPreview" class="border rounded" width="320" height="240" autoplay></video>
                        <br>
                        <!-- Button to toggle camera -->
                        <button type="button" id="toggleCameraPreview" class="btn btn-primary mt-2">Mulai Kamera</button>
                        <button type="button" id="toggleCameraSwitch" class="btn btn-secondary mt-2">Ubah Kamera</button>
                    </div>

                    <div class="mb-3 text-center">
                        <img id="photoPreview" width="320" height="240" class="border rounded">
                        <input type="hidden" name="imageDataPreview" id="imageDataPreview">
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        // JavaScript untuk menangani video capture dan kontrol kamera

        const videoPreview = document.getElementById('videoPreview');
        const captureButton = document.getElementById('capture');
        const toggleCameraButton = document.getElementById('toggleCameraPreview');
        const toggleCameraSwitch = document.getElementById('toggleCameraSwitch');
        const imageDataPreviewInput = document.getElementById('imageDataPreview');
        const canvasPreview = document.getElementById('canvas');
        const contextPreview = canvasPreview.getContext('2d');
        const photoPreview = document.getElementById('photoPreview');

        let stream;
        let currentDevice = 'environment'; // 'environment' = kamera belakang, 'user' = kamera depan

        // Function to start the camera
        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: currentDevice } })
                .then(s => {
                    stream = s;
                    videoPreview.srcObject = stream;
                    captureButton.disabled = false; // Enable capture button
                    toggleCameraButton.innerText = "Matikan Kamera"; // Change button text
                })
                .catch(err => {
                    console.error("Akses kamera gagal:", err);
                    alert("Gagal mengakses kamera.");
                });
        }

        // Function to stop the camera
        function stopCamera() {
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
                videoPreview.srcObject = null;
                captureButton.disabled = true; // Disable capture button
                toggleCameraButton.innerText = "Mulai Kamera"; // Reset button text
            }
        }

        // Function to switch camera between front and back
        function switchCamera() {
            currentDevice = (currentDevice === 'environment') ? 'user' : 'environment';
            stopCamera(); // Stop current camera
            startCamera(); // Start camera again with new facing mode
        }

        toggleCameraButton.addEventListener('click', () => {
            if (toggleCameraButton.innerText === "Mulai Kamera") {
                startCamera();
            } else {
                stopCamera();
            }
        });

        // Function to capture a photo
        captureButton.addEventListener('click', () => {
            canvasPreview.width = videoPreview.videoWidth;
            canvasPreview.height = videoPreview.videoHeight;
            contextPreview.drawImage(videoPreview, 0, 0, canvasPreview.width, canvasPreview.height);
            const imageData = canvasPreview.toDataURL('image/png');
            photoPreview.src = imageData;
            imageDataPreviewInput.value = imageData;
        });

        toggleCameraSwitch.addEventListener('click', switchCamera);

        function validateForm() {
            if (imageDataPreviewInput.value === '') {
                alert('⚠️ Anda belum mengambil foto!');
                return false;
            }
            return true;
        }
    </script>

    <?php include 'templates/footer.php'; ?>

</body>

</html>
