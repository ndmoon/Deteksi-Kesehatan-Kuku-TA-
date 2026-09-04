<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="ie=edge">
    <title>CEKU - Cek Kesehatan Kuku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #ffffff;
            color: #212529;
        }

        /* Navbar */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
            color: #EC407A !important;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: #EC407A;
            border: none;
            color: #fff;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #D81B60;
            transform: translateY(-2px) scale(1.03);
        }

        /* Hero */
        .hero {
            padding: 60px 20px;
            border-radius: 12px;
            background: linear-gradient(135deg, #F8BBD0, #FFD6E0);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        }

        .hero h1 {
            font-weight: 700;
            font-size: 2.2rem;
            color: #D81B60;
        }

        .hero p {
            font-size: 1rem;
            color: #495057;
        }

        .hero img {
            max-width: 100%;
            border-radius: 12px;
        }

        /* Upload Box */
        .upload-box {
            text-align: center;
            padding: 35px 20px;
            border: 2px dashed #EC407A;
            border-radius: 12px;
            background: #ffffff;
            transition: 0.3s;
        }

        .upload-box:hover {
            border-color: #D81B60;
            transform: translateY(-2px) scale(1.02);
        }

        .upload-box i {
            font-size: 3rem;
            color: #EC407A;
        }

        /* Features */
        .card {
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card-body i {
            font-size: 2.5rem;
            color: #EC407A;
            transition: transform 0.3s, color 0.3s;
        }

        .card:hover .card-body i {
            transform: scale(1.15);
            color: #D81B60;
        }

        /* Footer */
        .footer {
            background-color: #EC407A;
            color: #fff;
            padding: 20px 0;
            margin-top: 50px;
            font-weight: 500;
        }

        .text-muted {
            color: #6c757d !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 { font-size: 1.8rem; }
            .hero p { font-size: 0.95rem; }
            .card-body i { font-size: 2rem; }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-light sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="#">CEKU</a>
            <a href="/login" class="btn btn-primary rounded-pill px-4">Masuk</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero container my-5" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                <h1>Cek Kesehatan Kuku</h1>
                <p>
                    Aplikasi berbasis website yang membantu <strong>mengenali kondisi kuku</strong>
                    melalui analisis gambar menggunakan
                    <em>Machine Learning</em> (ML).
                </p>
                <a href="#upload" class="btn btn-primary rounded-pill px-4">Mulai Sekarang</a>
            </div>
            <div class="col-lg-6 col-md-12 text-center">
                <img src="{{ asset('images/img2.png') }}" alt="Ilustrasi Kuku" class="img-fluid rounded-3 shadow-sm">
            </div>
        </div>
    </section>

    <!-- Upload Box -->

    <section id="upload" class="container my-5" data-aos="fade-up">
        <div class="upload-box shadow-sm">
            <i class="fa fa-camera mb-3"></i>
            <h5 class="fw-bold">Deteksi Cepat</h5>
            <p class="text-muted">
                Unggah gambar kuku Anda untuk mendapatkan
                <strong>analisis awal kondisi kuku</strong> berdasarkan citra visual.
            </p>
            <a href="/login" class="btn btn-primary rounded-pill px-4 mt-2">Mulai Deteksi</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container text-center my-5">
        <h6 class="text-muted" data-aos="fade-up">Fitur Utama</h6>
        <h2 class="fw-bold mb-4" data-aos="fade-up">Teknologi Canggih untuk Kesehatan Kuku</h2>
        <p class="mb-5 text-muted" data-aos="fade-up">
            Aplikasi ini menggunakan <em>Machine Learning</em> (ML) untuk
            menganalisis gambar kuku, menampilkan kondisi kuku yang terdeteksi,
            serta memberikan <strong>informasi dan rekomendasi perawatan umum</strong>
            sebagai panduan awal bagi pengguna.
        </p>

        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="fa fa-camera mb-3"></i>
                        <h5 class="fw-bold">Unggah Gambar</h5>
                        <p class="text-muted">Unggah gambar kuku Anda dengan mudah dan cepat.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="fa fa-cogs mb-3"></i>
                        <h5 class="fw-bold">Analisis ML</h5>
                        <p class="text-muted">
                            Model <em>Machine Learning</em> menganalisis
                            pola visual kuku untuk mengenali
                            <strong>kemungkinan kondisi kuku</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="fa fa-file-alt mb-3"></i>
                        <h5 class="fw-bold">Hasil & Rekomendasi</h5>
                        <p class="text-muted">
                            Menampilkan hasil analisis disertai
                            <strong>informasi dan rekomendasi perawatan umum</strong>.
                            Untuk kondisi serius, pengguna dianjurkan
                            berkonsultasi dengan tenaga medis.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menambahkan disclaimer medis -->
    <section class="container my-5" data-aos="fade-up">
        <div class="alert alert-warning small text-center rounded-3">
            <strong>Catatan:</strong> Hasil analisis pada aplikasi ini
            <u>bukan diagnosis medis</u>.
            Aplikasi ini bertujuan sebagai alat bantu deteksi awal.
            Jika Anda mengalami keluhan, nyeri, atau kondisi kuku memburuk,
            segera periksakan diri ke dokter atau tenaga medis.
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer text-center" data-aos="fade-up">
        <p class="mb-0">&copy; <script>document.write(new Date().getFullYear());</script> CEKU. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, easing: 'ease-in-out', once: true });
    </script>
</body>
</html>
