<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CEKU - Auth')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #fff;
            font-family: 'Segoe UI', sans-serif;
            color: #212529;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        }

        h2, h3, h4, h5, .text-primary {
            color: #EC407A;
        }

        .btn-primary {
            background-color: #EC407A;
            border: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #D81B60;
            transform: translateY(-2px) scale(1.03);
        }

        a {
            color: #EC407A;
            text-decoration: none;
        }

        a:hover {
            color: #D81B60;
        }

        .form-check-label {
            color: #495057;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4" style="max-width: 420px; width: 100%;">
            <div class="text-center mb-4">
                <a class="text-decoration-none">
                    <h2 class="fw-bold">CEKU</h2>
                </a>
            </div>

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
