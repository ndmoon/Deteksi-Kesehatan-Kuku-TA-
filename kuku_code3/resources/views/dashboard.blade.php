@extends('layouts.app')

@section('title', 'Dashboard - CEKU')

@section('content')

<style>
    /* Container Kamera: Tetap pakai overlay */
    #camera-container {
        position: relative;
        display: inline-block;
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 12px;
    }

    /* Kotak Panduan: Hanya untuk kamera */
    .camera-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 45%; /* Sesuai ROI crop 45% */
        aspect-ratio: 1 / 1;
        border: 3px dashed #00ff00;
        border-radius: 10px;
        box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5); /* Gelap di luar kotak */
        pointer-events: none;
        z-index: 20;
    }

    /* Preview setelah foto diambil: Tanpa overlay */
    #preview-container {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #preview {
        max-height: 300px;
        max-width: 100%;
        object-fit: contain;
        border-radius: 8px;
        /* display: block;
        max-height: 300px;
        width: auto;
        border-radius: 8px; */
    }

</style>

<div class="text-center mb-5">
    <h2 class="fw-bold" style="color:#EC407A;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em" height="1em"
            fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"
            class="me-2">
            <path d="M7 2h10a4 4 0 0 1 4 4v7a6 6 0 0 1-6 6H9a6 6 0 0 1-6-6V6a4 4 0 0 1 4-4z"/>
            <rect x="8.5" y="9" width="7" height="9" rx="2.5"/>
            <path d="M9.8 11.3a4.4 4.4 0 0 1 4.4 0"/>
        </svg>
        Cek Kesehatan Kuku
    </h2>
    <p class="text-muted">Unggah gambar kuku Anda dan dapatkan analisis awal kesehatan dari citra visual</p>
</div>

<div class="card shadow-sm border-0 rounded-4 mb-5">
    <div class="card-body p-4 p-md-5">
        <form id="uploadForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="predictions" id="predictions">
            
            <div class="mb-4">
                <label for="image_path" class="form-label fw-bold">Unggah Foto Kuku Anda</label>
                <div id="drop-area" class="upload-box border rounded-3 p-4 text-center"
                     style="cursor:pointer; border:2px dashed #EC407A; background-color:#fff; transition:0.3s;">
                    <i class="bi bi-cloud-arrow-up mb-2 fs-1" id="upload-icon" style="color:#EC407A;"
                       data-bs-toggle="tooltip" title="Hanya file .jpg, .jpeg, .png maksimal 2MB"></i>
                    <div id="upload-instruction">
                        <p class="text-muted mb-1">Tarik & letakkan file di sini</p>
                        <p class="small text-muted">atau klik untuk memilih</p>
                    </div>
                    <input type="file" id="image_path" name="image_path" class="d-none" accept=".jpg,.jpeg,.png" required>
                    <div id="preview-container" class="d-none mt-3">
                        <div id="skeleton" class="skeleton-box rounded mb-2 d-flex align-items-center justify-content-center"
                            style="height:200px; width:100%;">
                            <div class="spinner-border" role="status" style="color:#EC407A;"></div>
                        </div>
                        
                        <img id="preview" class="img-fluid rounded shadow-sm d-none">

                        <div id="crop-overlay" class="overlay-guide d-none"></div>

                        <div id="file-info" class="mt-2 small text-secondary"></div>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="reset-btn">
                            <i class="bi bi-x-circle"></i> Reset
                        </button>
                    </div>
                    <div class="mb-4 text-center">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            id="open-camera-btn">
                        <i class="bi bi-camera"></i> Gunakan Kamera
                    </button>
                    </div>

                    <div id="camera-container" class="d-none text-center mb-4">
                        <div id="camera-guide" class="camera-overlay"></div>
                        
                        <video id="camera" autoplay playsinline class="rounded shadow-sm"></video>
                        
                        <canvas id="snapshot" class="d-none"></canvas>

                        <div class="mt-3">
                            <button type="button" class="btn btn-success rounded-pill px-4" id="capture-btn">
                                <i class="bi bi-camera-fill"></i> Ambil Foto
                            </button>
                            <button type="button" class="btn btn-outline-danger rounded-pill px-4 ms-2" id="close-camera-btn">
                                Tutup Kamera
                            </button>
                        </div>
                    </div>
                </div>
                
                <small id="error-image_path" class="text-danger d-none mt-2"></small>
                <small class="text-muted d-block mt-2">
                    ⚠️ Hanya file <strong>.jpg, .jpeg, .png</strong> dengan ukuran maksimal <strong>2MB</strong>.
                </small>
            </div>

            <!-- <div class="mb-3">
                <label for="nama" class="form-label fw-bold">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" required>
                <small id="error-nama" class="text-danger d-none"></small>
            </div> -->

            <!-- <div class="mb-3">
                <label for="usia" class="form-label fw-bold">Usia</label>
                <input type="number" id="usia" name="usia" class="form-control" required>
                <small id="error-usia" class="text-danger d-none"></small>
            </div> -->

            <div class="progress mb-3 d-none" id="progress-container">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar" style="width: 0%; background-color:#EC407A;" id="progress-bar"></div>
            </div>

            <button type="button" id="submit-btn" class="btn btn-primary rounded-pill px-4 w-100"
                    style="background-color:#EC407A; border:none;">
                <span id="btn-text">Kirim</span>
                <span id="btn-loading" class="spinner-border spinner-border-sm ms-2 d-none" style="color:#fff;"></span>
            </button>
        </form>
    </div>
</div>

<div id="hasil-container" class="d-none mt-5">
    <h4 class="fw-bold text-center mb-3">Hasil Analisis Kuku</h4>
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <!-- <p><strong>Nama :</strong> <span id="hasil-nama"></span></p> -->
            <!-- <p><strong>Usia :</strong> <span id="hasil-usia"></span> tahun</p> -->
            <p><strong>Kondisi Kuku :</strong> <br><span id="hasil-kondisi"></span></p>
            <p><strong>Gambar Kuku :</strong></p>
            <img id="hasil-gambar" class="img-fluid rounded mb-3 d-none" style="max-width: 300px;">
            <p><strong>Deskripsi Kondisi :</strong> <br><span id="hasil-deskripsi"></span></p>
            <p><strong>Kemungkinan atau tanda awal Masalah Kesehatan / Penyakit yang dialami :</strong></p>
            <ul id="hasil-penyakit" class="mb-3"></ul>
            <p><strong>Rekomendasi Perawatan Kuku :</strong></p>
            <ul id="hasil-rekomendasi"></ul>
            <div class="alert alert-warning border-0 rounded-4 p-3 mt-4" style="background-color: #fff3e0;">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-exclamation-triangle-fill fs-3" style="color: #fb8c00;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #ef6c00;">Penting: </h6>
                        <p class="small mb-0 text-dark" style="line-height: 1.5;">
                            Hasil analisis ini <strong>sepenuhnya berbasis pengenalan citra digital</strong> dan bertujuan hanya untuk edukasi/skrining awal. 
                            Sistem ini <strong>bukan merupakan diagnosis medis resmi</strong>. 
                            Segala tindakan kesehatan harus didasarkan pada konsultasi langsung dengan <strong>dokter atau tenaga medis profesional</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="window.location.reload()">
                    <i class="bi bi-arrow-clockwise"></i> Mulai Analisis Baru
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.17.0/dist/tf.min.js"></script>

<!-- <script>
    window.APP_CONFIG = {
        modelUrl: "{{ asset('model/model.json') }}",
        uploadUrl: "{{ route('upload') }}",
        csrfToken: "{{ csrf_token() }}"
    };
</script> -->

<script>
    window.UPLOAD_URL = "{{ route('upload') }}";
</script>

<script src="{{ asset('js/predict.js') }}"></script>
@endsection
