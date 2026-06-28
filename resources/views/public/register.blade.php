<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Informasi Penyewaan Aula POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="auth-body">

    <div class="auth-wrapper auth-register-width">
        <div class="auth-header">
            <img src="{{ asset('images/Logo_Polman.png') }}" alt="Logo POLMAN BABEL">
            <h1>POLMAN BABEL</h1>
            <p>Layanan Penyewaan Aula</p>
        </div>

        <div class="auth-card">
            <div class="auth-tabs">
                <a href="{{ route('login') }}" class="tab-link">Masuk</a>
                <a href="{{ route('register') }}" class="tab-link active">Daftar</a>
            </div>

            @if ($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

          <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="name" placeholder="John Doe" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nama@email.com" required>
                </div>

                <div class="form-group">
                    <label for="telepon">Nomor Telepon/WhatsApp</label>
                    <input type="text" id="telepon" name="phone" placeholder="081234567890" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="address" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-input-container">
                        <input type="password" id="password" name="password" placeholder="••••••" required>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePasswordVisibility('password')"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="password-input-container">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••" required>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePasswordVisibility('password_confirmation')"></i>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="terms" required>
                        <span class="terms-text">Saya menyetujui syarat & ketentuan penggunaan layanan</span>
                    </label>
                </div>

                <button type="submit" class="btn-auth-submit">Daftar</button>
            </form>

            <div class="auth-footer-text">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>

        <div class="auth-copyright">
            &copy; 2026 Polman Babel - Sistem Penyewaan Aula
        </div>
    </div>

    <script>
        function togglePasswordVisibility(id) {
            const passwordInput = document.getElementById(id);
            const icon = passwordInput.nextElementSibling;
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // Script Notifikasi Pop-up
        
    </script>
</body>
</html>