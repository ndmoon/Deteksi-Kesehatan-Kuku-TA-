document.addEventListener('DOMContentLoaded', () => {

    tf.setBackend('cpu');

    // Threshold untuk menolak input
    const CONFIDENCE_THRESHOLD = 0.6;
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    const maxSize = 5 * 1024 * 1024; // 5MB

    // Inisialisasi Tooltip Bootstrap
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

    // DOM Elements
    const fileInput = document.getElementById('image_path');
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('preview-container');
    const cropOverlay = document.getElementById('crop-overlay');
    const fileInfo = document.getElementById('file-info');
    const resetBtn = document.getElementById('reset-btn');
    const skeleton = document.getElementById('skeleton');
    const instruction = document.getElementById('upload-instruction');
    const uploadIcon = document.getElementById('upload-icon');
    const dropArea = document.getElementById('drop-area');

    // Camera Elements
    const video = document.getElementById('camera');
    const canvas = document.getElementById('snapshot');
    const cameraContainer = document.getElementById('camera-container');
    const cameraGuide = document.getElementById('camera-guide');
    const openCameraBtn = document.getElementById('open-camera-btn');
    const captureBtn = document.getElementById('capture-btn');
    const closeCameraBtn = document.getElementById('close-camera-btn');

    let model;
    let stream = null;
    let capturedFile = null;

    // LOAD MODEL TFJS
    async function loadModel() {
        tf.env().set('WEBGL_PACK', false);
        if (!model) {
            try {
                model = await tf.loadLayersModel("/model/model.json");
                console.log("Model TFJS siap digunakan");
            } catch (error) {
                console.error("Gagal memuat model:", error);
            }
        }
    }

    // LOGIKA KAMERA
    if(openCameraBtn) openCameraBtn.addEventListener('click', async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: "environment" }, 
                audio: false 
            });
            video.srcObject = stream;
            cameraContainer.classList.remove('d-none');
            cameraGuide.classList.remove('d-none');
            openCameraBtn.classList.add('d-none');
        } catch (err) {
            alert("Gagal mengakses kamera: " + err.message);
        }
    });

    if(closeCameraBtn) closeCameraBtn.addEventListener('click', stopCamera);

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        cameraContainer.classList.add('d-none');
        cameraGuide.classList.add('d-none');
        openCameraBtn.classList.remove('d-none');
    }

    if(captureBtn) captureBtn.addEventListener('click', async () => {

        const guideRect = cameraGuide.getBoundingClientRect();
        const videoRect = video.getBoundingClientRect();

        const scaleX = video.videoWidth / videoRect.width;
        const scaleY = video.videoHeight / videoRect.height;

        const cropX = Math.floor((guideRect.left - videoRect.left) * scaleX);
        const cropY = Math.floor((guideRect.top - videoRect.top) * scaleY);
        const cropW = Math.floor(guideRect.width * scaleX);
        const cropH = Math.floor(guideRect.height * scaleY);

        canvas.width = cropW;
        canvas.height = cropH;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, cropX, cropY, cropW, cropH, 0, 0, cropW, cropH);

        let quality = 0.7;
        let blob;

        do {
            blob = await new Promise(resolve =>
                canvas.toBlob(resolve, "image/jpeg", quality)
            );
            quality -= 0.1;
        } while (blob.size > maxSize && quality > 0.2);

        if (blob.size > maxSize) {
            alert("Gambar terlalu besar meskipun sudah dikompres.");
            return;
        }

        const file = new File([blob], "capture.jpg", { type: "image/jpeg" });
        capturedFile = file;

        handlePreview(file);
        stopCamera();
    });

    async function isImageBlurry(imgTensor) {
        const grayscale = tf.tidy(() => {
            return imgTensor.mean(2).expandDims(-1);
        });

        const laplacianKernel = tf.tensor4d(
            [0, 1, 0, 1, -4, 1, 0, 1, 0], 
            [3, 3, 1, 1]
        );

        const laplacian = tf.tidy(() => {
            return tf.conv2d(grayscale, laplacianKernel, 1, 'same');
        });

        const { variance } = tf.moments(laplacian);
        const varValue = (await variance.data())[0];

        grayscale.dispose();
        laplacian.dispose();
        laplacianKernel.dispose();

        console.log("Image Variance (Sharpness):", varValue);

        return varValue < 0.001; 
    }

    function handlePreview(file) {
        if (!validTypes.includes(file.type) || file.size > maxSize) {
            alert("File tidak valid atau terlalu besar.");
            return;
        }

        previewContainer.classList.remove('d-none');
        skeleton.classList.remove('d-none');
        preview.classList.add('d-none');

        const reader = new FileReader();
        reader.onload = e => {
            setTimeout(() => {
                preview.src = e.target.result;
                skeleton.classList.add('d-none');
                preview.classList.remove('d-none');

                fileInfo.textContent =
                    `${file.name} - ${(file.size / 1024).toFixed(1)} KB`;

                instruction.classList.add('d-none');
                uploadIcon.classList.add('d-none');
            }, 300);
        };
        reader.readAsDataURL(file);
    }

    // LOGIKA UPLOAD & PREVIEW
    if(dropArea) dropArea.addEventListener('click', () => fileInput.click());

    if(fileInput) fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        console.log("File selected:", file?.name, file?.type, file?.size);
        if (!file) return;
        capturedFile = file;
        handlePreview(file);
    });

    if(resetBtn) resetBtn.addEventListener('click', () => {
        fileInput.value = "";
        capturedFile = null;
        preview.src = "";
        previewContainer.classList.add('d-none');
        instruction.classList.remove('d-none');
        uploadIcon.classList.remove('d-none');
    });

    // PREPROCESS DENGAN CENTER CROP (ROI)
    async function processImage(file) {
        return new Promise(resolve => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = new Image();
                img.src = e.target.result;
                img.onload = () => {
                    let tensor = tf.browser.fromPixels(img).toFloat();
                    const [h, w] = tensor.shape.slice(0, 2);

                    const cropSize = Math.floor(Math.min(h, w) * 0.45);
                    const startY = Math.floor((h - cropSize) / 2);
                    const startX = Math.floor((w - cropSize) / 2);

                    console.log(`Original: ${w}x${h}, Cropping to: ${cropSize}x${cropSize} at (${startX},${startY})`);

                    tensor = tf.slice(tensor, [startY, startX, 0], [cropSize, cropSize, 3]);
                    tensor = tf.image.resizeBilinear(tensor, [224, 224]).div(255.0);

                    resolve(tensor);
                };
            };
            reader.readAsDataURL(file);
        });
    }

    // PREDIKSI
    async function predictTFJS(file) {
        if (!model) await loadModel();

        const imgTensor = await processImage(file);
        const blurry = await isImageBlurry(imgTensor); 
        if (blurry) {
            tf.dispose(imgTensor);
            return { valid: false, message: "Gambar terlalu buram (blur). Pastikan kamera fokus pada kuku Anda." };
        }

        const meanPixel = imgTensor.mean().dataSync()[0];
        if (meanPixel < 0.35 || meanPixel > 0.80) {
            tf.dispose(imgTensor);
            return { valid: false, message: "Pencahayaan kurang baik. Pastikan kuku terlihat jelas." };
        }

        const input = imgTensor.expandDims(0);
        const pred = model.predict(input);
        const probs = await pred.data();

        tf.dispose([imgTensor, input, pred]);

        const classNames = [
            'Clubbing', 
            'Garis_Gelap', 
            'Kuku_Membiru', 
            'Kuku_Putih', 
            'Kuku_Sehat', 
            'Onychogryphosis', 
            'Pitting'
        ];

        let predictions = classNames.map((name, i) => ({
            name,
            prob: probs[i]
        })).sort((a, b) => b.prob - a.prob);

        const top = predictions[0];

        return {
            valid: true,
            predictions: predictions.slice(0, 2),
            confidence: top.prob
        };
    }

    function showError(id, message) {
        const el = document.getElementById(`error-${id}`);
        if (el) {
            el.textContent = message;
            el.classList.remove('d-none');
        }
    }

    function clearErrors() {
        ['image_path'].forEach(id => {
            const el = document.getElementById(`error-${id}`);
            if (el) {
                el.textContent = '';
                el.classList.add('d-none');
            }
        });
    }

    // SUBMIT FORM
    const submitBtn = document.getElementById('submit-btn');
    if(submitBtn) submitBtn.addEventListener('click', async () => {

        clearErrors();

        const file = capturedFile || fileInput.files[0];

        if (!file) {
            showError('image_path', 'Gambar wajib diunggah');
            return;
        }

        document.getElementById('btn-loading').classList.remove('d-none');
        document.getElementById('btn-text').textContent = 'Mengirim...';

        const result = await predictTFJS(file);

        if (!result.valid) {
            showError('image_path', result.message);
            document.getElementById('btn-loading').classList.add('d-none');
            document.getElementById('btn-text').textContent = 'Kirim';
            return;
        }

        const form = document.getElementById('uploadForm');
        const formData = new FormData(form);
        if (file) formData.set('image_path', file);
        formData.set('predictions', JSON.stringify(result.predictions));

        fetch(window.UPLOAD_URL, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(r => {
            if (!r.ok) throw new Error("Upload gagal");
            return r.json();
        })
        .then(data => {
            document.getElementById('btn-loading').classList.add('d-none');
            document.getElementById('btn-text').textContent = 'Kirim';

            const kondisiEl = document.getElementById('hasil-kondisi');
            if (Array.isArray(data.kondisi) && data.kondisi.length > 0) {
                kondisiEl.innerHTML = data.kondisi.map(k => `${k.display_name} (${k.confidence}%)`).join('<br>');
            } else kondisiEl.textContent = '-';

            document.getElementById('hasil-deskripsi').textContent = data.description || '-';
            document.getElementById('hasil-gambar').src = preview.src;
            document.getElementById('hasil-gambar').classList.remove('d-none');

            const penyakitEl = document.getElementById('hasil-penyakit');
            penyakitEl.innerHTML = '';
            if (Array.isArray(data.penyakit) && data.penyakit.length > 0) {
                data.penyakit.forEach(p => {
                    const li = document.createElement('li');
                    li.innerHTML = `<strong>${p.penyakit_name}</strong>: ${p.description}`;
                    penyakitEl.appendChild(li);
                });
            } else penyakitEl.innerHTML = '<li>- Tidak ada data penyakit -</li>';

            const rekomendasiEl = document.getElementById('hasil-rekomendasi');
            rekomendasiEl.innerHTML = '';
            let rekomendasiData = data.rekomendasi;
            if (rekomendasiData && !Array.isArray(rekomendasiData)) {
                rekomendasiData = Object.values(rekomendasiData);
            }
            if (Array.isArray(rekomendasiData) && rekomendasiData.length > 0) {
                rekomendasiData.forEach(r => {
                    const li = document.createElement('li');
                    li.textContent = r;
                    rekomendasiEl.appendChild(li);
                });
            } else rekomendasiEl.innerHTML = '<li>- Tidak ada rekomendasi -</li>';

            document.getElementById('hasil-container').classList.remove('d-none');
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi kesalahan, silakan coba lagi.");
            document.getElementById('btn-loading').classList.add('d-none');
            document.getElementById('btn-text').textContent = 'Kirim';
        });

    });

});
