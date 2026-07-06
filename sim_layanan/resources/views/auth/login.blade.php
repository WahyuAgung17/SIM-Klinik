<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Admin | Klinik Cakra Husada</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- CSS Admin -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

    <style>

        :root{

            --primary:#1F6F5C;
            --primary-dark:#174E41;
            --paper:#F7F9FC;
            --text:#23313F;

        }

        body{

            font-family:'Inter',sans-serif;

            background:linear-gradient(135deg,#eef6f3,#ffffff);

            min-height:100vh;

        }

        .login-wrapper{

            min-height:100vh;

        }

        .left-panel{

            background:linear-gradient(160deg,#1F6F5C,#174E41);

            position:relative;

            overflow:hidden;

        }

        .left-panel img{

            width:100%;

            height:100%;

            object-fit:cover;

            opacity:.92;

        }

        .overlay{

            position:absolute;

            inset:0;

            background:rgba(12,45,38,.35);

        }

        .left-content{

            position:absolute;

            left:60px;

            bottom:60px;

            color:white;

            z-index:5;

            max-width:420px;

        }

        .left-content h1{

            font-family:'Fraunces',serif;

            font-size:44px;

            line-height:1.2;

            margin-bottom:20px;

        }

        .left-content p{

            opacity:.9;

            font-size:16px;

        }

        .login-card{

            width:100%;

            max-width:450px;

            border:none;

            border-radius:30px;

            box-shadow:0 20px 60px rgba(0,0,0,.08);

            overflow:hidden;

        }

        .login-header{

            text-align:center;

            margin-bottom:35px;

        }

        .logo{

            width:85px;

            height:85px;

            border-radius:50%;

            background:#E8F6F1;

            display:flex;

            align-items:center;

            justify-content:center;

            margin:auto;

            color:var(--primary);

            font-size:42px;

        }

        .login-header h3{

            margin-top:18px;

            font-family:'Fraunces',serif;

            color:var(--text);

        }

        .login-header p{

            color:#6c757d;

            margin-top:8px;

        }

        .form-control{

            border-radius:15px;

            height:55px;

            padding-left:48px;

            border:1px solid #d7dde5;

        }

        .form-control:focus{

            border-color:var(--primary);

            box-shadow:0 0 0 .15rem rgba(31,111,92,.15);

        }

        .input-icon{

            position:relative;

        }

        .input-icon i:first-child{

            position:absolute;

            left:18px;

            top:17px;

            color:#888;

        }

        .toggle-password{

            position:absolute;

            right:15px;

            top:15px;

            border:none;

            background:none;

            color:#777;

        }

        .btn-login{

            height:55px;

            border-radius:15px;

            background:var(--primary);

            border:none;

            font-weight:600;

            transition:.3s;

        }

        .btn-login:hover{

            background:var(--primary-dark);

            transform:translateY(-2px);

        }

        .back-link{

            text-decoration:none;

            color:var(--primary);

            font-weight:600;

        }

        @media(max-width:991px){

            .left-panel{

                display:none;

            }

            .login-card{

                margin:40px auto;

            }

        }

    </style>

</head>

<body>

<div class="container-fluid">

<div class="row login-wrapper">

    <!-- ========================= -->

    <!-- LEFT -->

    <!-- ========================= -->

    <div class="col-lg-7 left-panel p-0">

        <img src="{{ asset('assets/images/gedung-klinik.png') }}">

        <div class="overlay"></div>

        <div class="left-content">

            <span class="badge bg-light text-success mb-3 px-3 py-2">

                <i class="bi bi-heart-pulse-fill"></i>

                Sistem Informasi Klinik

            </span>

            <h1>

                Klinik Cakra Husada

            </h1>

            <p>

                Memberikan pelayanan kesehatan yang profesional,
                cepat, aman, dan terpercaya untuk seluruh masyarakat.

            </p>

        </div>

    </div>

    <!-- ========================= -->

    <!-- RIGHT -->

    <!-- ========================= -->

    <div class="col-lg-5 d-flex align-items-center justify-content-center">

        <div class="card login-card">

            <div class="card-body p-5">

                <div class="login-header">

                    <div class="logo">

                        <i class="bi bi-hospital-fill"></i>

                    </div>

                    <h3>Login Admin</h3>

                    <p>

                        Masuk ke Dashboard SIM Layanan Klinik

                    </p>

                </div>

                @if(session('success'))

                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>

                @endif

                @if($errors->any())

                    <div class="alert alert-danger">

                        {{ $errors->first() }}

                    </div>

                @endif

                <form method="POST"
                      action="{{ route('login.authenticate') }}">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Email

                        </label>

                        <div class="input-icon">

                            <i class="bi bi-envelope"></i>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                placeholder="Masukkan Email"
                                required>

                        </div>

                    </div>

                    <div class="mb-4">

                        <label class="form-label fw-semibold">

                            Password

                        </label>

                        <div class="input-icon">

                            <i class="bi bi-lock"></i>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan Password"
                                required>

                            <button
                                type="button"
                                class="toggle-password"
                                onclick="togglePassword()">

                                <i id="toggleIcon" class="bi bi-eye"></i>

                            </button>

                        </div>

                    </div>

                    <div class="form-check mb-4">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="remember"
                            id="remember">

                        <label
                            class="form-check-label"
                            for="remember">

                            Ingat Saya

                        </label>

                    </div>

                    <button class="btn btn-login text-white w-100">

                        <i class="bi bi-box-arrow-in-right me-2"></i>

                        Login ke Dashboard

                    </button>

                </form>

                <hr class="my-4">

                <div class="text-center">

                    <a href="{{ route('profil.index') }}"
                       class="back-link">

                        <i class="bi bi-arrow-left"></i>

                        Kembali ke Company Profile

                    </a>

                </div>

                <div class="text-center mt-4 text-muted small">

                    © {{ date('Y') }}

                    Klinik Cakra Husada

                </div>

            </div>

        </div>

    </div>

</div>

</div>

<script>

function togglePassword(){

    let password=document.getElementById('password');

    let icon=document.getElementById('toggleIcon');

    if(password.type==="password"){

        password.type="text";

        icon.className="bi bi-eye-slash";

    }else{

        password.type="password";

        icon.className="bi bi-eye";

    }

}

</script>

</body>

</html>