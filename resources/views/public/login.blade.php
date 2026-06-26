<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Informasi Penyewaan Aula POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="auth-body">

    <div class="auth-wrapper">
        <div class="auth-header">
            <img src="{{ asset('images/Logo_Polman.png') }}" alt="Logo POLMAN BABEL">
            <h1>POLMAN BABEL</h1>
            <p>Layanan Penyewaan Aula</p>
        </div>

        <div class="auth-card">
            <div class="auth-tabs">
                <a href="{{ route('login') }}" class="tab-link active">Masuk</a>
                <a href="{{ route('register') }}" class="tab-link">Daftar</a>
            </div>

           <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nama@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-input-container">
                        <input type="password" id="password" name="password" placeholder="••••••" required>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePasswordVisibility('password')"></i>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-auth-submit">Masuk</button>
            </form>

            <div class="auth-footer-text">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
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
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0b3a7b'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Masuk',
                text: 'Email atau password yang Anda masukkan salah.',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>
</body>
</html>