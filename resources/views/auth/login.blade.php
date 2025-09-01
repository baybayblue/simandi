<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simandi | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    
    <!-- Custom CSS untuk tampilan yang lebih baik -->
    <style>
        body {
            /* Membuat background dengan gradient yang menarik */
            background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
        }
        .login-box {
            width: 400px; /* Sedikit lebih lebar agar tidak sempit */
        }
        .login-card-body, .card {
            /* Efek kartu transparan (glassmorphism) */
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px; /* Sudut lebih melengkung */
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .login-logo a {
            color: #495057; /* Teks lebih gelap agar mudah dibaca */
            font-weight: 700;
        }
        .btn-primary {
            background-color: #6a63e8;
            border-color: #6a63e8;
            border-radius: 8px; /* Tombol melengkung */
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #554fd0;
            border-color: #554fd0;
            transform: translateY(-2px); /* Efek tombol terangkat saat disentuh */
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .input-group .form-control, .input-group-text {
            border-radius: 8px; /* Input field dan ikon melengkung */
        }
        .login-card-body .input-group {
            margin-bottom: 1.5rem !important; /* Jarak antar input lebih besar */
        }
        .brand-image {
            width: 70px;
            height: 70px;
            margin-bottom: 1rem;
            border-radius: 50%;
            background-color: white;
            padding: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo text-center">
        <!-- Pastikan logo ada di public/dist/img/simandi-logo.png -->
        <img src="{{ asset('dist/img/simandi-logo.png') }}" alt="Logo Simandi" class="brand-image">
        <br>
        <a href="#"><b>Simandi</b> Laundry</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Silakan masuk untuk memulai sesi Anda</p>

            <!-- Menampilkan error validasi -->
            @if ($errors->any())
                <div class="alert alert-danger" style="border-radius: 8px;">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">
                                Ingat Saya
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>

