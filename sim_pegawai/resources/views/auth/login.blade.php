<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Klinik | Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');
        
        body {
            font-family: 'Nunito', sans-serif !important;
            background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%) !important;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        
        .login-box {
            width: 420px;
        }
        
        .card-custom {
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            background: #ffffff;
        }
        
        .card-header-custom {
            background: #ffffff;
            border-bottom: none;
            padding: 40px 30px 10px;
        }
        
        .card-body-custom {
            padding: 20px 40px 40px;
        }
        
        .login-logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1e293b;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .login-logo i {
            font-size: 2.5rem;
            color: #3b82f6;
            margin-bottom: 10px;
        }
        
        .login-logo span {
            color: #3b82f6;
        }
        
        .form-control {
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            padding: 0.75rem 1.25rem;
            height: auto;
            font-size: 0.95rem;
            background-color: #f8fafc;
            border-right: none;
        }
        
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background-color: #ffffff;
        }
        
        .input-group-text {
            border-radius: 0 12px 12px 0;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            color: #64748b;
            border-left: none;
        }
        
        .input-group:focus-within .form-control,
        .input-group:focus-within .input-group-text {
            border-color: #3b82f6;
            background-color: #ffffff;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            color: white;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(37,99,235,0.2);
            width: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(37,99,235,0.3);
            color: white;
        }
        
        .alert-modern {
            border-radius: 12px;
            border: none;
            background-color: #fee2e2;
            color: #991b1b;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 12px;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-custom">
    <div class="card-header text-center card-header-custom">
      <a href="#" class="login-logo">
        <i class="fas fa-clinic-medical"></i>
        <div>Klinik<span>Terintegrasi</span></div>
      </a>
    </div>
    
    <div class="card-body card-body-custom">
      <p class="login-box-msg text-muted font-weight-bold mb-4" style="font-size: 0.95rem;">Selamat Datang! Silakan masuk untuk melanjutkan.</p>
      
      @if($errors->any())
        <div class="alert alert-modern text-center mb-4">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
        </div>
      @endif

      <form action="/login" method="post">
        @csrf
        <div class="form-group mb-3">
          <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">ALAMAT EMAIL</label>
          <div class="input-group">
            <input type="email" name="email" class="form-control font-weight-bold" placeholder="nama@klinik.com" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
          </div>
        </div>
        
        <div class="form-group mb-4">
          <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">KATA SANDI</label>
          <div class="input-group">
            <input type="password" name="password" class="form-control font-weight-bold" placeholder="••••••••" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
          </div>
        </div>
        
        <div class="row mt-4">
          <div class="col-12">
            <button type="submit" class="btn btn-login"><i class="fas fa-sign-in-alt mr-2"></i> Masuk ke Sistem</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>